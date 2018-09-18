<?php

namespace Mailsceptor\Tests\Unit;

use Mailsceptor\Tests\TestCase;
use Mailsceptor\Models\Email;

class ModelTest extends TestCase
{
    public function test_model_creation()
    {
        $model = Email::create([
          'subject' => 'Testing Model Creation',
          'body' => 'This is one fine body',
          'to' => 'bob@example.org',
          'cc' => null,
          'bcc' => null,
        ]);

        $this->assertTrue($model->exists());
    }
}
