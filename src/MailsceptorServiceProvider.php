<?php

namespace Mailsceptor;

use Illuminate\Mail\MailServiceProvider;
use Illuminate\Support\Facades\Route;

class MailsceptorServiceProvider extends MailServiceProvider
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
        ]);

        $this->loadMigrationsFrom(__DIR__.'/Migrations');
    }

    /**
     * Register the core swift mailed with mailsceptor as an outer layer.
     *
     * @return void
     */
    public function registerSwiftMailer()
    {
        parent::registerSwiftMailer();

        $this->registerMailsceptorSwiftMailer();
    }

    /**
     * Replace the swift mailer instance with Mailsceptor as a hook.
     *
     * @return void
     */
    private function registerMailsceptorSwiftMailer()
    {
        $this->app['swift.mailer'] = new \Swift_Mailer(new MailsceptorTransport($this->app['swift.mailer']));
    }
}
