<h6 align="center">
    <img src="https://i.imgur.com/LazjHZN.png" width="120"/>
</h6>

<h3 align="center">
    Laravel Mailsceptor
</h3>

<h6 align="center" style="max-width: 500px;">
    Intercept, reroute, store and/or preview emails before they're submitted.
</h6>

<p align="center">
<a href="https://travis-ci.org/stephenlake/laravel-mailsceptor"><img src="https://travis-ci.org/stephenlake/laravel-mailsceptor.svg?branch=master" alt="Build Status"></a>
<a href="https://github.styleci.io/repos/148940371"><img src="https://github.styleci.io/repos/148940371/shield?branch=master" alt="StyleCI"></a>
<a href="https://github.com/stephenlake/laravel-mailsceptor"><img src="https://img.shields.io/github/release/stephenlake/laravel-mailsceptor.svg" alt="Release"></a>
<a href="https://github.com/stephenlake/laravel-mailsceptor"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

<h2 align="center"></h2>
<br>


# Laravel Mailsceptor

**Laravel Mailsceptor** cathes outgoing emails before they're submitted where you can modify the message recipients and save the output while still allowing the regular email sending process to continue as usual with any existing email drivers in place.

Made with ❤️ by [Stephen Lake](http://stephenlake.github.io/)

## Getting Started

Install the package via composer.

    composer require stephenlake/laravel-mailsceptor

Register the service provider in `config/app.php` (Not required in Laravel 5.7+)

    Mailsceptor\MailsceptorServiceProvider:class

Publish and edit the configuration file accordingly

    php artisan vendor:publish --provider=Mailsceptor\MailsceptorServiceProvider:class

Run the migrations (Only required if `database.enabled=true` in `config/mailsceptor.php`)

    php artisan migrate

That's it. Send an email using a Laravel driver and enjoy.

#### See [extended documentation](https://stephenlake.github.io/laravel-mailsceptor)

## License

This library is licensed under the MIT License - see the [LICENSE.md](LICENSE) file for details.
