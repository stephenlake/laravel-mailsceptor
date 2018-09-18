<?php

namespace Mailsceptor;

use Illuminate\Mail\Transport\Transport as LaravelMailTransport;

class MailsceptorTransport extends LaravelMailTransport
{
    /**
     * Top level mailer instance.
     *
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * Mailsceptor config.
     *
     * @var array
     */
    private $config;

    /**
     * The mailer original message instance.
     *
     * @var Swift_Mime_SimpleMessage
     */
    private $originalMessage;

    /**
     * The mailer message instance.
     *
     * @var Swift_Mime_SimpleMessage
     */
    private $hookedMessage;

    /**
     * Construct!
     *
     * @param $mailer \Swift_Mailer
     *
     * @return void
     */
    public function __construct($mailer)
    {
        $this->mailer = $mailer;
        $this->config = config('mailsceptor');
    }

    /**
     * Performs checks against what's enabled in the config and bounces the
     * email message content accordingly.
     *
     * @param $message \Swift_Mime_SimpleMessage
     * @param $failedRecipients
     *
     * @return void
     */
    public function send(\Swift_Mime_SimpleMessage $message, &$failedRecipients = null)
    {
        $this->originalMessage = $message;
        $this->hookedMessage = $message;

        $this->handleEventHook();
        $this->handleRedirectHook();
        $this->handleDatabaseHook();

        if ($this->config['proceedAfterHooks']) {
            $this->mailer->send($this->originalMessage);
        }
    }

    /**
     * Handle database hook.
     *
     *
     * @return void
     */
    private function handleDatabaseHook()
    {
        if (($this->config['database']['enabled'] ?? false)) {
            $model = $this->config['database']['model'] ?? \Mailsceptor\Models\Email::class;
            $model = new $model();
            $model->create([
                'subject' => $this->originalMessage->getSubject(),
                'body'    => $this->originalMessage->getBody(),
                'to'      => json_encode($this->originalMessage->getTo()),
                'cc'      => json_encode($this->originalMessage->getCc()),
                'bcc'     => json_encode($this->originalMessage->getBcc()),
            ]);
        }
    }

    /**
     * Handle event hook.
     *
     *
     * @return void
     */
    private function handleEventHook()
    {
        if (($this->config['event']['enabled'] ?? true)) {
            event(new $this->config['event']['event']($this->originalMessage));
        }
    }

    /**
     * Handle redirect hook.
     *
     *
     * @return void
     */
    private function handleRedirectHook()
    {
        if (($this->config['redirect']['enabled'] ?? false)) {
            $this->hookedMessage->setTo(null);
            $this->hookedMessage->setCc(null);
            $this->hookedMessage->setBcc($this->config['redirect']['destinations']);

            $this->mailer->send($this->hookedMessage);
        }
    }
}
