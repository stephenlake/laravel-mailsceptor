<?php

namespace Mailsceptor;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;

class MailsceptorServiceProvider extends ServiceProvider
{
    /**
     * Boot up Mailsceptor.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/Config/mailsceptor.php' => config_path('mailsceptor.php'),
            __DIR__.'/Migrations/2018_09_06_135819_create_emails_table.php' => database_path('migrations')
        ]);

        $this->registerListener();
    }

    private function registerListener()
    {
        Event::listen(\Illuminate\Mail\Events\MessageSending::class, function ($event) {
            return (new MailsceptorInterception($event->message))->intercept();
        });
    }
}
