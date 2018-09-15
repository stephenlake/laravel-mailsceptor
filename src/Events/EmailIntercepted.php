<?php

namespace Mailsceptor\Events;

use Illuminate\Queue\SerializesModels;

class EmailIntercepted
{
    use SerializesModels;

    /**
     * The Swift message container.
     *
     * @var Swift_Mime_SimpleMessage
     */
    public $message;

    /**
     * Create a new event instance with the email message content.
     *
     * @param \Swift_Mime_SimpleMessage $order
     *
     * @return void
     */
    public function __construct(\Swift_Mime_SimpleMessage $message)
    {
        $this->message = $message;
    }
}
