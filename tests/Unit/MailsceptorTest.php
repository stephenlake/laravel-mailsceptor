<?php

namespace Mailsceptor\Tests\Unit;

use Mailsceptor\Models\Email;
use Mailsceptor\Tests\TestCase;

class MailsceptorTest extends TestCase
{
    public function test_model_creation()
    {
        $model = Email::create([
          'subject' => 'Testing Model Creation',
          'body'    => 'This is one fine body',
          'to'      => 'bob@example.org',
          'cc'      => null,
          'bcc'     => null,
        ]);

        $this->assertTrue($model->exists());
    }
}
