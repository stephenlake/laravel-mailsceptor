<?php

namespace Mailsceptor;

use Illuminate\Support\Facades\Mail;

class Mailsception
{
    /**
     * The Swift message container.
     *
     * @var Swift_Message
     */
    public $message;

    /**
     * Create a new event instance with the email message content.
     *
     * @param \Swift_Message $message
     *
     * @return void
     */
    public function __construct(\Swift_Message $message)
    {
        $this->message = $message;
        $this->config = config('mailsceptor');
    }

    /**
     * Process hooks.
     *
     * @return void
     */
    public function intercept()
    {
        $continue = true;

        if (isset($this->config['beforeHook']) && class_exists($this->config['beforeHook'])) {
            $beforeHook = new $this->config['beforeHook']();
            $beforeHook->hooked($this->message);

            $continue = $beforeHook->process();
        }

        if ($continue) {
            $this->handleRedirectHook();
            $this->handleDatabaseHook();
        }

        return $this->config['proceedAfterHooks'] ? true : false;
    }

    /**
     * Handle database hook.
     *
     * @return void
     */
    private function handleDatabaseHook()
    {
        if (($this->config['model'] ?? false)) {
            $model = new $this->config['model']() ?? \Mailsceptor\Models\Email::class;
            $model->create([
                'subject' => $this->message->getSubject(),
                'body'    => $this->message->getBody(),
                'to'      => $this->message->getTo() ? array_keys($this->message->getTo()) : [],
                'cc'      => $this->message->getCc() ? array_keys($this->message->getCc()) : [],
                'bcc'     => $this->message->getBcc() ? array_keys($this->message->getBcc()) : [],
            ]);
        }
    }

    /**
     * Handle redirect hook.
     *
     * @return void
     */
    private function handleRedirectHook()
    {
        if (($redirectionTo = ($this->config['redirect'] ?? false))) {
            $intendedDestination = array_keys($this->message->getTo());

            if (!count($intendedDestination)) {
                return;
            }

            $intendedDestination = $intendedDestination[0];

            if ($intendedDestination != $redirectionTo) {
                Mail::send([], [], function ($m) use ($redirectionTo) {
                    $m->getSwiftMessage()
                      ->getHeaders()
                      ->addTextHeader('x-mailscepted', 'true');

                    $m->to($redirectionTo)
                      ->subject("[Mailsceptor] {$this->message->getSubject()}")
                      ->setBody($this->message->getBody(), 'text/html');
                });
            }
        }
    }

    /**
     * Overload constructed configuration file.
     *
     * @return void
     */
    public function setConfig(array $config)
    {
        $this->config = $config;
    }
}
