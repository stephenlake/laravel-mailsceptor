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
            $beforeHook->hook($this->message);

            $continue = $beforeHook->process();
        }

        if ($continue) {
            $this->handleRedirectHook();
            $this->handleDatabaseHook();
        }

        return $this->config['proceedAfterHooks'];
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
                'to'      => json_encode($this->message->getTo()),
                'cc'      => json_encode($this->message->getCc()),
                'bcc'     => json_encode($this->message->getBcc()),
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
        if (($destination = ($this->config['redirect'] ?? false))) {
            $intendedDestination = array_keys($this->message->getTo());

            if (count($intendedDestination)) {
                $intendedDestination = $intendedDestination[0];
            } else {
                $intendedDestination = '';
            }

            if ($intendedDestination != $destination) {
                Mail::send([], [], function ($m) use ($destination) {
                    $m->to($destination)
                      ->subject("[Mailsceptor] {$this->message->getSubject()}")
                      ->setBody($this->message->getBody(), 'text/html');
                });
            }
        }
    }
}
