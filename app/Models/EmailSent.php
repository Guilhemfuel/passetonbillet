<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailSent extends Model
{
    public $table = 'emails_sent';

    public $fillable = [
        'user_id',
        'email_class',
        'ticket_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id'       => 'integer',
        'ticket_id' => 'integer',
        'email_class'   => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'user_id'       => 'required|exists:users,id',
        'ticket_id' => 'exists:tickets,id',
        'email_class'   => 'required'
    ];

    /**
     * Relationships
     */

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function ticket()
    {
        return $this->belongsTo('App\Ticket');
    }
}
