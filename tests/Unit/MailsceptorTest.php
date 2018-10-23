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

        $this->assertTrue($emails->count() == 2);

        $redirectedEmail = Email::find(1);
        $originalEmail = Email::find(2);

        $this->assertTrue($redirectedEmail->subject == "[Mailsceptor] {$emailSubject}");
        $this->assertTrue($redirectedEmail->body == $emailBody);
        $this->assertTrue($redirectedEmail->to[0] == $this->app['config']->get('mailsceptor.redirect'));

        $this->assertTrue($originalEmail->subject == $emailSubject);
        $this->assertTrue($originalEmail->body == $emailBody);
        $this->assertTrue($originalEmail->to[0] == $emailTo);
    }
}
