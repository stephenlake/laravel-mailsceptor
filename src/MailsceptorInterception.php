<?php

namespace Mailsceptor;

use Illuminate\Support\Facades\Mail;

class MailsceptorInterception
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

    public function intercept()
    {
        $this->handleRedirectHook();
        $this->handleDatabaseHook();

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

            if (!is_string($destination)) {
                $destination = 'sample@example.org';
            }

            if ($intendedDestination != $destination) {
                Mail::send([], [], function ($m) use ($destination) {
                    $m->to($destination)
                      ->subject($this->message->getSubject())
                      ->setBody($this->message->getBody(), 'text/html');
                });
            }
        }
    }
}
