<h6 align="center">
    <img src="https://raw.githubusercontent.com/stephenlake/laravel-mailsceptor/master/docs/assets/laravel-mailsceptor.png"/>
</h6>

<h6 align="center">
    Intercept, reroute and store emails before they're submitted.
</h6>

# Getting Started

**NOTE:** This package requires Laravel 5.7 or later.

## Install via Composer

Install the package via composer.

    composer require stephenlake/laravel-mailsceptor

## Publish Configuration

Publish the configuration file.

    php artisan vendor:publish --provider="Mailsceptor\MailsceptorServiceProvider" --tag="config"

## Setup your email driver

This package does not intefere with mail driver configurations nor does it provide free credentials. You will need to setup your mail driver with its credentials in order to use the package successfully.

# Usage

Technically, usage is optional as there's no code required in order to start using Mailsceptor. As soon as the mail driver is fired for sending, Mailsceptor will intercept the request and process its tasks.

Mailsceptor injects itself by listening for the `\Illuminate\Mail\Events\MessageSending::class` event at which point it processes a configuration defined hook named `beforeHook` and if that hook returns true it will then process all internal remaining hooks.


## Configuration

### Redirect

The redirect configuration option allows your application to re-route an email from one address to another, this is particularly useful when testing outbound emails on your development environment and you need to use real-world email addresses.

To enable the redirecting of emails, either:

- Edit your .env to include the `MAILSCEPTOR_REDIRECT_DESTINATION` key with the value of an email address.

or

- Edit the `config/mailsceptor.php` config file and replace the `redirect` value with the email address.

If you do not wish to use the redirection option, enter a value of `false`.

### Database Storage

If you wish to store emails in the database, you'll need to publish the migration:

    php artisan vendor:publish --provider="Mailsceptor\MailsceptorServiceProvider" --tag="migration"

Then run

    php artisan migrate

The `model` field in the configuration file allows you define your own email model, if doing so, your model should extend the provided one as it uses mutators for storing and retrieving the data.

### Before Hook

The `beforeHook` field contains a value pointing to the `MailsceptotHook` class which you may extend, this class is called before any other hooks are fired and must return `true` if the rest of the hooks may continue, for example:

```php
<?php

namespace App;

use Mailsceptor\MailsceptorHook;

class MyCustomHook extends MailsceptorHook
{
    public function process()
    {
        // public property containing the email message
        $email = $this->swiftMessage;

        $hooksMayContinue = false;

        if ($email->getSubject() == 'You are pretty.') {
            $hooksMayContinue = true;
        }

        // Allow the rest of the internal hooks to continue
        return $hooksMayContinue;
    }
}
```

### Proceed After Hooks

The `proceedAfterHooks` field defines whether or not the normal emailing procedure should continue, as in, whether or not the original email should still be delivered to its original intended recipient after all internal hooks have taken place. Set to `true` to continue or `false` to prevent delivery.
