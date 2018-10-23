<?php

namespace Mailsceptor\Models;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    /**
     * Attribute that defines the primey key column type in migrations.
     *
     * @var string
     */
    protected $tableKeyType = 'increments';

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
