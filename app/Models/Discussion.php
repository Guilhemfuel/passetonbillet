<?php

namespace App\Models;

use App\Ticket;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Nicolaslopezj\Searchable\SearchableTrait;

class Discussion extends Model
{
    use SoftDeletes, SearchableTrait;

    CONST DENIED = - 1;
    CONST AWAITING = 0;
    CONST ACCEPTED = 1;
    const SOLD = 2;

    public $table = 'discussions';

    public $fillable = [
        'ticket_id',
        'buyer_id',
        'status',
        'price',
        'currency'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'ticket_id' => 'integer',
        'buyer_id'  => 'integer',
        'status'    => 'integer',
        'price'     => 'integer',
        'currency'  => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'buyer_id'  => 'required|exists:users,id',
        'ticket_id' => 'required|exists:tickets,id',
        'price'     => 'required|integer',
        'currency'  => 'required',
    ];

    /**
     * Relationships of the model (used for eager loading)
     */
    public static $relationships = [ 'buyer', 'ticket' ];

    /**
     * Searchable rules.
     *
     * @var array
     */
    protected $searchable = [
        /**
         * Columns and their priority in search results.
         * Columns with higher values are more important.
         * Columns with equal values have equal importance.
         *
         * @var array
         */
        'columns' => [
            'users.first_name'       => 8,
            'users.last_name'       => 8,
            'users.email'           => 8,
            'tickets.provider_code' => 10,
        ],
        'joins'   => [
            'tickets' => [ 'discussions.ticket_id', 'tickets.id' ],
            'users'   => [ 'tickets.user_id', 'users.id' ],
        ],
    ];

    /**
     * Mutators
     */

    public function getStatusTextAttribute()
    {
        if ( $this->ticket->sold_to_id != null ) {
            if ( $this->ticket->sold_to_id == $this->buyer->id ) {
                return 'Sold here';
            } else {
                return 'Sold';
            }
        }

        switch ( $this->status ) {
            case static::DENIED :
                return 'Denied';
                break;
            case static::AWAITING:
                return 'Awaiting';
            case static::ACCEPTED:
                return 'Accepted';
        }

        return '-';
    }

    public function getSellerAttribute()
    {
        if ($this->ticket) {
            return $this->ticket->user;
        }
        dd($this->id);
        return null;
    }

    /**
     * Methods
     */

    /**
     * Returns true if given user hasn't read the last message he received
     *
     * @param User $user
     *
     * @return bool
     */
    public function unread( User $user )
    {
        $lastMessageReceived = $this->messages()->orderBy( 'created_at', 'desc' )
                                    ->where( 'sender_id', '!=', $user->id )->first();

        return $lastMessageReceived && $lastMessageReceived->read_at == null;
    }

    /**
     * Relationships
     */

    public function buyer()
    {
        return $this->belongsTo( 'App\User' );
    }

    public function ticket()
    {
        return $this->belongsTo( 'App\Ticket' );
    }

    public function lastMessage()
    {
        return $this->hasOne( 'App\Models\Message', 'discussion_id' )->latest();
    }

    public function messages()
    {
        return $this->hasMany( 'App\Models\Message', 'discussion_id' )->orderBy( 'created_at' );
    }

    /**
     *
     * Boot
     *
     */

    protected static function boot()
    {
        parent::boot();

        static::deleting( function ( $ticket ) {
            $ticket->messages()->delete();
        } );
    }

    /**
     *  To array, to be used by emails
     */

    public function toArray()
    {
        return [
            'id'         => $this->id,
            'status'     => $this->status,
//            'buyer'        => $this->buyer,
//            'seller'       => $this->seller,
//            'ticket'       => $this->ticket,
            'price'      => $this->price,
//            'last_message' => $this->last_message,
            'currency'   => $this->currency,
            'updated_at' => $this->updated_at,
        ];
    }

}
