<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Migration
    |--------------------------------------------------------------------------
    |
    | If you would like to make use of Mailsceptor's email model and store all
    | emails in the database, enable it here. You can extend the base model
    | with your own class if you wish. The migration primary key of the table
    | will use defined 'tableKeyType' aatribute defined on the model which
    | defaults to 'increments'.
    |
    */

    'database' => [
        'enabled' => env('MAILSCEPTOR_DATABASE_ENABLED', false),
        'model' => \Mailsceptor\Models\Email::class
    ],


    /*
    |--------------------------------------------------------------------------
    | Redirect
    |--------------------------------------------------------------------------
    |
    | During local testing, you may want to intercept and redirect all outgoing
    | emails to your own email address or a list of developer addresses. You
    | may do so here by enabling redirect and providing them in the destinations
    | array. All outgoing emails will be rerouted.
    |
    */

    'redirect' => [
        'enabled' => env('MAILSCEPTOR_REDIRECT_ENABLED', false),
        'destinations' => [
            env('MAILSCEPTOR_REDIRECT_DESTINATIONS', [
              'email1@example.org',
              'email2@example.org'
            ])
        ]
    ],


    /*
    |--------------------------------------------------------------------------
    | Event
    |--------------------------------------------------------------------------
    |
    | If enabled, the defined event will be fired whenever an email is caught
    | by the intercepter. This allows you to define your own logic or handling
    | of caught messages. An instance of Swift_Mime_SimpleMessage will be passed
    | to the event class.
    |
    | See https://laravel.com/docs/master/events for information on creating
    | an event listener.
    |
    | Important: If allowContinue is set to false, even if redirect is disabled
    | the email will be caught and will NOT be submitted to its destination. This
    | should only be set to false if you wish to handle the email submission
    | yourself via a custom driver or other means.
    |
    */

    'event' => [
      'enabled' => env('MAILSCEPTOR_EVENT_ENABLED', false),
      'event' => \Mailsceptor\Events\EmailIntercepted::class,
      'allowContinue' => true
    ],


    /*
    |--------------------------------------------------------------------------
    | Preview
    |--------------------------------------------------------------------------
    |
    | If enabled, the HTML generated from the email will be saved to the defined
    | path and a log entry will be created in the default log writer which prints
    | the filename of the output HTML file which you can then open to view the
    | produced content.
    |
    | Setting overwriteLast to true will use a single file gor every generated
    | HTML file saving you disk space. Set to false to generate a new file for
    | every email.
    |
    */
    'preview' => [
      'enabled' => env('MAILSCEPTOR_PREVIEW_ENABLED', false),
      'path' => sys_get_temp_dir(),
      'overwriteLast' => true
    ],

];
