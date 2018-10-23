<?php

namespace Mailsceptor\Tests\Unit;

use Illuminate\Support\Facades\Mail;
use Mailsceptor\Models\Email;
use Mailsceptor\Tests\TestCase;

class MailsceptorTest extends TestCase
{
    public function testAllInOne()
    {
        $emailsCount = Email::count();

        $this->assertTrue($emailsCount === 0);

        $emailBody = 'Hi Bob!';
        $emailTo = 'bob@example.org';
        $emailSubject = 'What a crazy cool email!';

        Mail::raw($emailBody, function ($message) use ($emailTo, $emailSubject) {
            $message->to($emailTo)->subject($emailSubject);
        });

        $emails = Email::get();

        $this->assertTrue($emails->count() > 0);

        $redirectedEmail = Email::first();

        $this->assertTrue($redirectedEmail->subject == $emailSubject);
        $this->assertTrue($redirectedEmail->body == $emailBody);
        $this->assertTrue($redirectedEmail->to[0] == $emailTo);
    }
}
