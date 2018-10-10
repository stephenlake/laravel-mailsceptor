<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Proceed After Hooks
    |--------------------------------------------------------------------------
    |
    | If set to true, the original message as it were unmodified will be submitted
    | to the original recipient after all hooks have been executed.
    |
    */
    'proceedAfterHooks' => env('MAILSCEPTOR_PROCEED_AFTER', true),

    /*
    |--------------------------------------------------------------------------
    | Database Storage
    |--------------------------------------------------------------------------
    |
    | If you would like to store all outgoing emails to database, you can use
    | the default provided model or your own which extends the default.
    |
    | Comment out the following line or set to false to disable.
    |
    */

    'model' => \Mailsceptor\Models\Email::class,

    /*
    |--------------------------------------------------------------------------
    | Redirect
    |--------------------------------------------------------------------------
    |
    | You can redirect outgoing emails to an alternative or additional email
    | address using the below. When the above 'proceeedAfterHooks' is set to
    | false, all outgoing emails will *only* be sent to this address.
    |
    */

    'redirect' => env('MAILSCEPTOR_REDIRECT_DESTINATION', false),

];
