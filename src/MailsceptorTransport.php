<?php

namespace Mailsceptor;

use Illuminate\Mail\Transport\Transport as LaravelMailTransport;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class MailsceptorTransport extends LaravelMailTransport
{
    /**
     * Top level mailer instance
     *
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * Mailsceptor config
     *
     * @var array
     */
    private $config;

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
        $mailTo = implode(',', array_keys($message->getTo() ?? []));
        $mailBody = $message->getBody();
        $mailSubject = $message->getSubject();
        $mailCc = implode(',', array_keys($message->getCc() ?? []));
        $mailBcc = implode(',', array_keys($message->getBcc() ?? []));

        $redirectEnabled = $this->config['redirect']['enabled'] ?? false;

        if ($redirectEnabled) {
            $redirectDestinations = $this->config['redirect']['destinations'];

            if (!is_array($redirectDestinations)) {
                $redirectDestinations = [$redirectDestinations];
            }

            $mailTo = implode(',', $redirectDestinations);
            $mailBody = $message->getBody();
            $mailSubject = $message->getSubject();

            $message->setTo(null);
            $message->setBcc($redirectDestinations);
            $message->setSubject($mailSubject);
        }

        $databaseEnabled = $this->config['database']['enabled'] ?? false;

        if ($databaseEnabled) {
            $model = $this->config['database']['model'] ?? \Mailsceptor\Models\Email::class;
            $model = new $model;
            $model->create([
                'body'    => $mailBody,
                'to'      => $mailTo,
                'cc'      => $mailCc,
                'bcc'     => $mailBcc,
                'subject' => $mailSubject
            ]);
        }

        $previewEnabled = $this->config['preview']['enabled'] ?? false;

        if ($previewEnabled) {
            $overwriteLast = $this->config['preview']['overwriteLast'] ?? true;

            $file = $this->config['preview']['path'] . '/' . ($overwriteLast ? 'mailsceptor-preview.html' : 'mainsceptor-preview-' . microtime() . '.html');

            file_put_contents($file, $message->getBody());

            Log::info('Mailsceptor created email preview: file://' . $file);
        }

        $mayContinue = true;

        $eventEnabled = $this->config['event']['enabled'] ?? true;

        if ($eventEnabled) {
            event(new $this->config['event']['event']($message));

            $mayContinue = $this->config['event']['allowContinue'];
        }

        if ($mayContinue) {
            $this->mailer->send($message);
        }
    }
}
