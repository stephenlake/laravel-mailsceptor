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
      'to' => 'array',
      'cc' => 'array',
      'bcc' => 'array'
    ];

    /**
     * Getter for $tableKeyType.
     *
     * @return array
     */
    public function getTableKeyType()
    {
        return $this->tableKeyType;
    }

    /**
     * Mutator for the to attribute. Returns an array of email
     * addresses from the raw comma separated line.
     *
     * @return array
     */
    public function getToAttribute($value)
    {
        return explode(',', $value);
    }

    /**
     * Mutator for the cc attribute. Returns an array of email
     * addresses from the raw comma separated line.
     *
     * @return array
     */
    public function getCcAttribute($value)
    {
        return explode(',', $value);
    }

    /**
     * Mutator for the bcc attribute. Returns an array of email
     * addresses from the raw comma separated line.
     *
     * @return array
     */
    public function getBccAttribute($value)
    {
        return explode(',', $value);
    }
}
