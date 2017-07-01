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
 */
	class Station extends \Eloquent {}
}

namespace App{
/**
 * App\Ticket
 *
 * @property-read \App\Station $arrivalCity
 * @property-read \App\Station $departureCity
 * @property-read \App\Train $train
 * @property-read \App\User $user
 */
	class Ticket extends \Eloquent {}
}

namespace App{
/**
 * App\Train
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Ticket[] $tickets
 */
	class Train extends \Eloquent {}
}

namespace App{
/**
 * App\User
 *
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Ticket[] $tickets
 */
	class User extends \Eloquent {}
}

