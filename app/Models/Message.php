<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    public $table = 'messages';

    public $fillable = [
        'discussion_id',
        'sender_id',
        'message'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'discussion_id' => 'integer',
        'sender_id'  => 'integer',
        'message'    => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'discussion_id'  => 'required|exists:discussions,id',
        'sender_id' => 'required|exists:users,id',
        'message'    => 'required|string'
    ];

    /**
     * Relationships
     */

    public function discussion()
    {
        return $this->belongsTo( 'App\Model\Discussion' );
    }

    public function sender()
    {
        return $this->belongsTo( 'App\User' );
    }
}
