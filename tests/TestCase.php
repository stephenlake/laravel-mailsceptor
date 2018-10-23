<?php

namespace Mailsceptor\Tests;

use Illuminate\Support\Facades\Schema;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use DatabaseMigrations;

    public function setup()
    {
        parent::setup();

        $this->app->setBasePath(__DIR__.'/../');
    }

    protected function getPackageProviders($app)
    {
        return [
            \Illuminate\Mail\MailServiceProvider::class,
            \Mailsceptor\MailsceptorServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);

        $app['config']->set('mail.driver', 'LOG');

        $app['config']->set('mailsceptor.proceedAfterHooks', false);
        $app['config']->set('mailsceptor.model', \Mailsceptor\Models\Email::class);
        $app['config']->set('mailsceptor.beforeHook', \Mailsceptor\MailsceptorHook::class);
        $app['config']->set('mailsceptor.redirect', 'stephen@closurecode.com');

        Schema::dropIfExists('emails');
        Schema::create('emails', function ($table) {
            $table->increments('id');
            $table->string('subject')->nullable();
            $table->string('body')->nullable();
            $table->string('to')->nullable();
            $table->string('cc')->nullable();
            $table->string('bcc')->nullable();
            $table->timestamps();
        });
    }
}
