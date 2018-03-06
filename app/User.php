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

    protected $dates = [ 'deleted_at' ];

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
        ]
    ];

    public static $rules = [
        'first_name'    => 'required',
        'last_name'     => 'required',
        'gender'        => 'required|numeric',
        'phone'         => 'required',
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
     * User is admin if status = 100
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->status == 100;
    }

    public function getFullNameAttribute()
    {
        if (\App::environment()=='testing' || (\Auth::check() && \Auth::user()->id == $this->id )){
            return ucfirst( $this->first_name ) . ' ' . ucfirst( $this->last_name );
        }
        return ucfirst( $this->first_name ) . ' ' . substr(ucfirst( $this->last_name ),0,1).'.';
    }

    public function getRoleAttribute()
    {
        switch ( $this->status ) {
            case 100:
                return 'Admin';
            case 1:
                return 'User';
            case 0:
                return 'Unconfirmed User';
            case - 1:
                return 'Uninvited User';
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

    public function getIdVerifiedAttribute(){
        return ($this->idVerification!==null&&$this->idVerification->accepted) ?:false;
    }

    public function getCountUnreadMessagesAttribute()
    {
        return \DB::table('notifications')
                  ->where('notifiable_id',$this->id)
                  ->whereIn('type',['App\Notifications\MessageNotification','App\Notifications\OfferNotification'])
                  ->whereNull('read_at')
                  ->count();
    }

    public function getMemberSinceAttribute()
    {
        $date = new Carbon($this->created_at);
        return __('profile.member_since').$date->toFormattedDateString();
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

    /**
     * Offers made by user
     */
    public function offers()
    {
        return $this->hasMany('App\Models\Discussion', 'buyer_id');
    }

    /**
     * Tickets bought by user
     */
    public function ticketsBought(){}
}
