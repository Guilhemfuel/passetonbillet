<?php
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App{
/**
 * App\Station
 *
 * @property-read mixed $name
 * @property-read mixed $eurostar_id
 * @property-read mixed $short_name
 * @property-read mixed $country
 * @property-read mixed $timezone_txt
 * @property-read mixed $timezone
 * @mixin \Eloquent
 * @property int $id
 * @property string $name_fr
 * @property string $name_en
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Station whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Station whereEurostarId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Station whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Station whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Station whereNameFr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Station whereShortName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Station whereTimezone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Station whereTimezoneTxt($value)
 */
	class Station extends \Eloquent {}
}

namespace App{
/**
 * App\Ticket
 *
 * @property-read \App\Train $train
 * @property-read \App\User  $user
 * @mixin \Eloquent
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property int $train_id
 * @property int $user_id
 * @property string|null $user_notes
 * @property int|null $price
 * @property string|null $currency
 * @property int $flexibility
 * @property string $class
 * @property int $bought_price
 * @property string $bought_currency
 * @property bool $inbound
 * @property string $eurostar_code
 * @property string $buyer_email
 * @property string $buyer_name
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ticket whereBoughtCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ticket whereBoughtPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ticket whereBuyerEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ticket whereBuyerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ticket whereClass($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ticket whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ticket whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ticket whereEurostarCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ticket whereFlexibility($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ticket whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ticket whereInbound($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ticket wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ticket whereTrainId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ticket whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ticket whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ticket whereUserNotes($value)
 */
	class Ticket extends \Eloquent {}
}

namespace App{
/**
 * App\Train
 *
 * @property-read $number
 * @property-read $departure_date
 * @property-read $departure_time
 * @property-read $departure_city
 * @property-read $arrival_date
 * @property-read $arrival_time
 * @property-read $arrival_city
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Ticket[] $tickets
 * @mixin \Eloquent
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Station $arrivalCity
 * @property-read \App\Station $departureCity
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Train whereArrivalCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Train whereArrivalDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Train whereArrivalTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Train whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Train whereDepartureCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Train whereDepartureDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Train whereDepartureTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Train whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Train whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Train whereUpdatedAt($value)
 */
	class Train extends \Eloquent {}
}

namespace App{
/**
 * App\User
 *
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Ticket[] $tickets
 * @mixin \Eloquent
 * @property int $id
 * @property string $email
 * @property string $password
 * @property string|null $remember_token
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string $first_name
 * @property string $last_name
 * @property int|null $gender
 * @property string|null $phone
 * @property string|null $birthdate
 * @property string|null $facebook_id
 * @property string|null $linkedin_id
 * @property bool|null $identity_confirmed
 * @property int $status
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereBirthdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereFacebookId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereIdentityConfirmed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereLinkedinId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

