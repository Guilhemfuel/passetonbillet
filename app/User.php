<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Nicolaslopezj\Searchable\SearchableTrait;


/**
 * App\User
 *
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Ticket[] $tickets
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use Notifiable, SearchableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'first_name','last_name','gender','phone','phone_country','birthdate','language',
        'email', 'password',
        'facebook_id','linkedin_id','identity_confirmed', //TODO: create a model profile linked to user where is this data
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
            'users.last_name' => 10,
        ]
    ];

    public static $rules = [
        'first_name' => 'required',
        'last_name' => 'required',
        'gender' => 'required|numeric',
        'phone' => 'required',
        'phone_country' => 'required',
        'birthdate' => 'required|date',
        'language' => 'required',
        'email' => 'required|email|unique:users',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'status'
    ];

    /**
     * Relationships of the model (used for eager loading)
     */
    public static $relationships = ['tickets'];

    /**
     *   MUTATORS
     */

    /**
     *
     * User is admin if status = 100
     *
     * @return bool
     */
    public function isAdmin(){
        return $this->status == 100;
    }

    public function getFullNameAttribute()
    {
        return ucfirst($this->first_name).' '.ucfirst($this->last_name);
    }

    public function getRoleAttribute(){
        switch ($this->status){
            case 100:
                return 'Admin';
            case 1:
                return 'User';
            case 0:
                return 'Unconfirmed User';
            case -1:
                return 'Uninvited User';
        }
    }

    /**
     * RELATIONSHIPS
     */
    public function tickets()
    {
        return $this->hasMany('App\Ticket');
    }
}
