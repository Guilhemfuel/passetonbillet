<?php

namespace App;

use App\Models\Discussion;
use App\Models\Message;
use App\Notifications\ResetPasswordNotification;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Nicolaslopezj\Searchable\SearchableTrait;

class User extends Authenticatable
{
    use Notifiable, SearchableTrait, SoftDeletes;

    protected $dates = [ 'deleted_at', 'birthdate' ];

    const STATUS_BANNED_USER = -100;
    const STATUS_USER = 1;
    const STATUS_UNCONFIRMED_USER = 0;
    const STATUS_UNINVITED_USER = -1;
    const STATUS_ADMIN = 100;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'first_name',
        'last_name',
        'gender',
        'phone',
        'phone_country',
        'birthdate',
        'language',
        'location',
        'picture',
        'email',
        'password',
    ];

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
            'users.first_name' => 10,
            'users.last_name'  => 10,
            'users.email'  => 8,
        ]
    ];

    public static $rules = [
        'first_name'    => 'required',
        'last_name'     => 'required',
        'gender'        => 'required|numeric',
        'phone'         => 'required|unique:phone',
        'phone_country' => 'required',
        'birthdate'     => 'required|date',
        'language'      => 'required',
        'email'         => 'required|email|unique:users',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'status',
        'email_token',
        'fb_id'
    ];

    /**
     * Send the password reset notification.
     *
     * @param  string $token
     *
     * @return void
     */
    public function sendPasswordResetNotification( $token )
    {
        $this->notify( new ResetPasswordNotification( $token ) );
    }

    /**
     *   MUTATORS
     */

    /**
     *
     * User is admin if status = STATUS_ADMIN
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->status == self::STATUS_ADMIN;
    }

    public function getFullNameAttribute()
    {
        if (\App::environment()=='testing' || (\Auth::check() && \Auth::user()->isAdmin() )){
            return ucfirst( $this->first_name ) . ' ' . ucfirst( $this->last_name );
        }
        return ucfirst( $this->first_name ) . ' ' . substr(ucfirst( $this->last_name ),0,1).'.';
    }

    public function getRoleAttribute()
    {
        switch ( $this->status ) {
            case self::STATUS_ADMIN:
                return 'Admin';
            case self::STATUS_USER:
                return 'User';
            case self::STATUS_UNCONFIRMED_USER:
                return 'Unconfirmed';
            case self::STATUS_UNINVITED_USER:
                return 'Uninvited';
            case self::STATUS_BANNED_USER:
                return 'Banned';
        }
    }

    public function getPictureAttribute( $picture )
    {
        if ($picture) return $picture;
        return asset('img/picture-default.jpg');
    }

    public function getPhoneVerifiedAttribute()
    {
        if ($this->phone==null || $this->phone_country==null) return false;
        return true;
    }

    public function getPhoneVerificationSentAttribute()
    {
        return $this->phoneVerification != null;
    }

    public function getPhoneCountryCodeAttribute(  )
    {
        $countryCodes = [
            'FR' => 33,
            'GB' => 44,
            'BE' => 32
        ];

        return $countryCodes[$this->phone_country];
    }

    public function getIdVerifiedAttribute(){
        return ($this->idVerification!==null&&$this->idVerification->accepted) ?:false;
    }

    public function getIdVerificationPendingAttribute(){
        return $this->idVerification!==null && $this->idVerification->accepted == null;
    }

    public function setBirthdateAttribute($value) {
        try {
            $this->attributes['birthdate'] = Carbon::createFromFormat( 'd/m/Y', $value );
        } catch (\Exception $e) {
            // do nothing
        }
    }

    /**
     * Return true if used is verified or if has uploaded an id that was not denied
     *
     * @return bool
     */
    public function getIdUploadedAttribute(){
        return $this->id_verified || $this->idVerification!==null;
    }

    public function getCountUnreadMessagesAttribute()
    {
        // Count of unread: unanswered received offers + unread message
        $count = count($this->offersReceived->where('status',Discussion::AWAITING));
        foreach ($this->allOffers as $discussion){
            if($discussion->unread($this)){
                $count++;
            }
        }
        return $count;
    }

    public function getBannedAttribute()
    {
        return $this->status == self::STATUS_BANNED_USER;
    }

    // Lowercase email

    public function getEmailAttribute($value)
    {
        return strtolower($value);
    }

    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = strtolower($value);
    }


    /**
     * RELATIONSHIPS
     */

    /**
     * Relationships of the model (used for eager loading)
     */
    public static $relationships = [ 'tickets' ];

    public function tickets()
    {
        return $this->hasMany( 'App\Ticket' );
    }

    public function boughtTickets()
    {
        return $this->hasMany( 'App\Ticket','sold_to_id' );
    }

    public function phoneVerification()
    {
        return $this->hasOne('App\Models\Verification\PhoneVerification');
    }

    public function idVerification()
    {
        return $this->hasOne('App\Models\Verification\IdVerification');
    }

    public function emailsReceived()
    {
        return $this->hasMany( 'App\Models\EmailSent','user_id' );
    }

    public function stats()
    {
        return $this->hasMany('App\Models\Statistic');
    }

    /**
     * Offers
     */
    public function offers()
    {
        return $this->hasMany('App\Models\Discussion', 'buyer_id');
    }

    public function offersReceived()
    {
        return $this->hasManyThrough('App\Models\Discussion', 'App\Ticket');
    }

    public function getAllOffersAttribute()
    {
        return $this->offers->concat($this->offersReceived);
    }

    /**
     * Tickets bought by user
     */
    public function ticketsBought(){
        return $this->hasMany('App\Models\Discussion', 'buyer_id')
            ->where('status',Discussion::SOLD);
    }

    /**
     *
     * Boot
     *
     */

    protected static function boot()
    {
        parent::boot();

        static::deleting( function ( $user ) {
            foreach ($user->all_offers as $offer) {
                $offer->delete();
            }
            $user->tickets()->delete();
            $user->idVerification()->delete();
        } );
    }
}
