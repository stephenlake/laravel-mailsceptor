<?php

namespace Mailsceptor\Models;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    /**
     * Fillable columns during hydration.
     *
     * @var array
     */
    protected $fillable = [
        'subject',
        'body',
        'to',
        'cc',
        'bcc',
    ];

    /**
     * Casts attributes.
     *
     * @var array
     */
    protected $casts = [
      'to'  => 'array',
      'cc'  => 'array',
      'bcc' => 'array',
    ];
}
