<h6 align="center">
    <img src="https://raw.githubusercontent.com/stephenlake/laravel-mailsceptor/master/docs/assets/laravel-mailsceptor.png"/>
</h6>

<h6 align="center">
    Intercept, reroute, store and/or preview emails before they're submitted.
</h6>

<p align="center">
<a href="https://travis-ci.org/stephenlake/laravel-mailsceptor"><img src="https://img.shields.io/travis/stephenlake/laravel-mailsceptor/master.svg?style=flat-square" alt="Build Status"></a>
<a href="https://github.styleci.io/repos/148940371"><img src="https://github.styleci.io/repos/148940371/shield?branch=master&style=flat-square" alt="StyleCI"></a>
<a href="https://github.com/stephenlake/laravel-mailsceptor"><img src="https://img.shields.io/github/release/stephenlake/laravel-mailsceptor.svg?style=flat-square" alt="Release"></a>
<a href="https://github.com/stephenlake/laravel-mailsceptor/LICENSE.md"><img src="https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square" alt="License"></a>
</p>

<br><br>

# Laravel Mailsceptor

**Laravel Mailsceptor** catches outgoing emails before they're submitted where you can modify the message recipients and save the output while still allowing the regular email sending process to continue as usual with any existing email drivers in place.

Made with ❤️ by [Stephen Lake](http://stephenlake.github.io/)

## Getting Started

Install the package via composer.

    composer require stephenlake/laravel-mailsceptor

Register the service provider in `config/app.php` (Not required in Laravel 5.7+)

    Mailsceptor\MailsceptorServiceProvider:class

Publish and edit the configuration file accordingly

    php artisan vendor:publish --provider="Mailsceptor\MailsceptorServiceProvider"

That's it. Send an email using a Laravel driver and enjoy.

#### See [documentation](https://stephenlake.github.io/laravel-mailsceptor) for configuration and usage.

## License

This library is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details.
