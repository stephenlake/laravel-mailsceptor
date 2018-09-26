<h6 align="center">
    <img src="https://raw.githubusercontent.com/stephenlake/laravel-mailsceptor/master/docs/assets/laravel-mailsceptor.png"/>
</h6>

<h6 align="center">
    Intercept, reroute, store and/or preview emails before they're submitted.
</h6>

<p align="center">
<a href="https://travis-ci.org/stephenlake/laravel-mailsceptor"><img src="
https://img.shields.io/travis/stephenlake/laravel-mailsceptor/master.svg?style=flat-square" alt="Build Status"></a>
<a href="https://github.styleci.io/repos/148940371"><img src="https://github.styleci.io/repos/148940371/shield?branch=master&style=flat-square" alt="StyleCI"></a>
<a href="https://github.com/stephenlake/laravel-mailsceptor"><img src="https://img.shields.io/github/release/stephenlake/laravel-mailsceptor.svg?style=flat-square" alt="Release"></a>
<a href="https://github.com/stephenlake/laravel-mailsceptor/LICENSE.md"><img src="https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square" alt="License"></a>
</p>

# Getting Started

## Install via Composer

Install the package via composer.

    composer require-dev stephenlake/laravel-mailsceptor

## Register Service Provider

Register the service provider in `config/app.php` (Not required in Laravel 5.7+)

    Mailsceptor\MailsceptorServiceProvider:class

## Publish Configuration

Publish the configuration file accordingly

    php artisan vendor:publish --provider="Mailsceptor\MailsceptorServiceProvider"

Run through the documenation and modify according to your needs.

# Configuration

The Mailsceptor configuration file lives alongside all other Laravel configuration files as `config/mailsceptor.php`. If you do not see this file, ensure you have followed the quickstart guide correctly and run through all steps as instructed.

The configuration is mostly self explanatory and contains inline comments to assist you where possible. Each of the config registered hooks are independent from  one another and can be enabled and disabled at any time by setting the respective hook `enabled` value to `false`.

# Hooks

Mailsceptor contains a set of hooks to assist you in getting setup as quickly as possible. Below we describe each and how to configure them. If you wish to disable all internal hooks and define your own, skip to the Event hook.

## Database

Sometimes it may be useful to store all sent emails in the database for logging and/or security purposes, whatever your motivation, Mailsceptor caters for it. If you want to make use of the database storage, it's important that you first read this the following before running your migrations.

Set the `database.enabled` configuration value to `true` and then optionally configure your model.

### Email Model

Mailsceptor contains an [email model](https://github.com/stephenlake/laravel-mailsceptor/blob/master/src/Models/Email.php) which contains some attributes that define how the migration will be executed, for instance, if your primary key columns are UUID's you may want to provide the same blueprint for the email model.

The default primary key type is `increments` which is the standard integer autoincrement type and the default table name is the pluralised model name (emails).

If you do not wish to change the defaults, simply run `php artisan migrate`.

### Custom Model

You may extend the `\Mailsceptor\Models\Email` class with your own model and then define either or both of the following attributes with your own values to override the defaults:

    // The table name
    protected $table = 'emails';

    // The table primary key migration type
    protected $tableKeyType = 'increments';

**Important:** Remember to update the model class on the `database.model` value in `config/mailsceptor.php`, then run `php artisan migrate`.

## Redirect

The redirect hook catches all outbound emails and reroutes them to a new single or set of email addresses, put simple, any outbound emails will have their `to`, `cc` and `bcc` destinations overwritten with the specified destination email addresses in the `redirect.destinations` array within the config file.

For example, submitting an email to `stephen@example.org` with the following configuration will capture the outbound email, stop it and broadcast it to `developer-john@example.org` and `developer-jane@example.org`. The original email address will not receive the email.

```php
'redirect' => [
    'enabled'      => env('MAILSCEPTOR_REDIRECT_ENABLED', false),
    'destinations' => [
        env('MAILSCEPTOR_REDIRECT_DESTINATIONS', [
          'developer-john@example.org',
          'developer-jane@example.org',
        ]),
    ],
],
```

**Note:** When using the dotenv to assign destination emails, the format is a simple comma separated string:

    MAILSCEPTOR_REDIRECT_DESTINATIONS=developer-john@example.org,developer-jane@example.org

## Preview

The preview hook grabs the outbound HTML body of the email message and saves it to a file within your system temporary directory by default (this is now a configurable path). This allows you to view the email in your web browser and get a feel of the emails appearance.

_Note:_ When the file is stored, the absolute path to the file will be printed to the log file.

## Event

The event hook allows you to capture the email interception event and handle the process going forward yourself. You can either tell Mailsceptor to catch, halt and forward the event or continue as normal and forward the event.

Setting the configuration value `event.allowContinue` to `false` will prevent the email from being submitted and forward the event.

See [Larave Events Documentation](https://laravel.com/docs/master/events) for information on creating an event listener to process the event.

# Known Issues

-   Preview Hook:
    -   When viewing the email, images cannot be served correctly using the file:// protocol.
