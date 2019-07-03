<?php

namespace App\Listeners\Admin\Warnings;

use App\Events\Admin\IdAcceptedEvent;
use App\Models\AdminWarning;
use App\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Class CheckAcceptedIdListener
 * @package App\Listeners\Admin\Warnings
 *
 * An admin can't check manually that an id wasn't already used. Therefore, this listener tries
 * to look for potential similar ids, and alert admin if it finds one.
 */
class CheckAcceptedIdListener implements ShouldQueue
{
    const SIMILARITY_PERCENTAGE = 70;
    const ID_CLOSENESS = 100;

    /**
     * Handle the event.
     *
     * @param  object $event
     *
     * @return void
     */
    public function handle( IdAcceptedEvent $event )
    {
        $user = $event->idVerification->user;

        // Find users with same birthdate, as that's we are sure of it
        $otherUsers = User::where( 'birthdate', $user->birthdate )
                          ->where('id','!=',$user->id)->get();

        // If no users matched, simply end
        if ( count( $otherUsers ) == 0 ) {
            return true;
        }

        // Now look for user with either a similar name, or a similar firstname
        $similarUsers = [];
        foreach ( $otherUsers as $otherUser ) {

            $percent = null;
            // Check firstname
            similar_text( strtolower( $user->first_name ), strtolower( $otherUser->first_name ), $percent );
            if ( $percent > self::SIMILARITY_PERCENTAGE ) {
                $similarUsers[] = $otherUser;
                continue;
            }

            // Check Lastname
            similar_text( strtolower( $user->last_name ), strtolower( $otherUser->last_name ), $percent );
            if ( $percent > self::SIMILARITY_PERCENTAGE) {
                $similarUsers[] = $otherUser;
                continue;
            }
        }

        // If no users matched, simply end
        if ( count( $similarUsers ) == 0 ) {
            return true;
        }

        // Create a warning for each user
        foreach ($similarUsers as $similarUser) {

            // If the id of users are very close (i.e double account, not fraud, ignore)
            if (abs($similarUser->id - $user->id) < self::ID_CLOSENESS ) {
                continue;
            }

            $data = [
                'message' => 'An id that was recently accepted, looks really similar to a precedent one. Please check.',
                'id_verified_for' => $user->id,
                'id_verified_for_name' => $user->full_name,
                'similar_user_id' => $similarUser->id,
                'similar_user_name' => $similarUser->full_name
            ];

            AdminWarning::create( [
                'action' => AdminWarning::SIMILAR_ID_ACCEPTED,
                'link'   => route( 'users.edit', $user->id ),
                'data'   => $data
            ] );
        }

        return;
    }
}
