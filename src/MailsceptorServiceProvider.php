<?php

namespace Mailsceptor;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

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
        ], 'config');

        $this->publishes([
          __DIR__.'/Migrations/migration.php' => database_path('migrations/2018_09_06_135819_create_emails_table.php'),
        ], 'migrations');

        $this->registerListener();
    }

    private function registerListener()
    {
        Event::listen(\Illuminate\Mail\Events\MessageSending::class, function ($event) {
            return (new Mailsception($event->message))->intercept();
        });
    }
}
