<?php

namespace Mailsceptor;

class MailsceptorHook
{
    public $swiftMessage;

    /**
     * Capture the submitting message and process any defined hooks.
     *
     * @param \Swift_Message $message
     *
     * @return void
     */
    public function hooked(\Swift_Message $swiftMessage)
    {
        $this->swiftMessage = $message;

        return $this->process();
    }

    /**
     * Process hook and return bool whether or not the internal
     * Mailsceptor hooks may continue.
     *
     * @return void
     */
    public function process()
    {
        return true;
    }
}
