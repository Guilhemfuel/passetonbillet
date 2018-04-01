<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use SoftDeletes;

    public $table = 'messages';

    public $fillable = [
        'discussion_id',
        'sender_id',
        'message',
        'read_at'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'discussion_id' => 'integer',
        'sender_id'     => 'integer',
        'message'       => 'string',
        'read_at'       => 'date'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'discussion_id' => 'required|exists:discussions,id',
        'sender_id'     => 'required|exists:users,id',
        'message'       => 'required|string',
        'read'          => 'date'
    ];

    /**
     * Mutator
     */

    public function getReceiverAttribute()
    {
        if ( $this->discussion->seller->id == $this->sender_id ) {
            return $this->discussion->buyer;
        } else {
            return $this->discussion->seller;
        }
    }

    /**
     * Relationships
     */

    public function discussion()
    {
        return $this->belongsTo( 'App\Models\Discussion' );
    }

    public function sender()
    {
        return $this->belongsTo( 'App\User' );
    }

}
