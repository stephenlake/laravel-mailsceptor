<h6 align="center">
    <img src="https://raw.githubusercontent.com/stephenlake/laravel-mailsceptor/master/res/laravel-mailsceptor.png"/>
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


## Quickstart

Install the package via composer.

    composer require stephenlake/laravel-mailsceptor

Register the service provider in `config/app.php` (Not required in Laravel 5.7+)

    Mailsceptor\MailsceptorServiceProvider:class

Publish and edit the configuration file accordingly

    php artisan vendor:publish --provider=Mailsceptor\MailsceptorServiceProvider:class

That's it. Send an email using a Laravel driver and enjoy.
