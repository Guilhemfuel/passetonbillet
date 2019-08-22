<?php


namespace App\Helper;

use App\Http\Resources\UserRessource;
use App\User;

/**
 * Class used to interract with amplitude's api
 *
 * Class Amplitude
 * @package App\Helper
 */
class Amplitude
{
    /**
     * List of events supported
     */
    const EVENTS = [
        // Auth
        'login',
        'register',
        'confirm_email',
        'register_facebook_connect_button',
        'login_facebook_connect_button',
        'delete_account',

        // Selling
        'retrieve_tickets', // Use automatic form to retrieve tickets
        'add_ticket', // Publish ticket on ptb
        'accept_offer',
        'deny_offer',
        'sell_ticket', // Mark ticket as sold
        'change_ticket_price',
        'delete_ticket',

        // Alerts
        'create_alert',
        'open_alert_modal',

        // Buying
        'ticket_search',
        'send_offer',
        'open_modal_call',
        'show_number',
        'show_ticket_contact',
        'discussion_phone_click',

        // Nav
        'nav_buy_button',
        'nav_sell_button',
        'nav_register_button',

        // Affiliate
        'affiliate_click'
    ];

    const SESSION_VAR = 'amplitude-events';

    /**
     * Store events to be added to amplitude into sessions.
     * User can be optionally passed, when it's an action from a known user that isn't logged such as
     * confirm email, or register.
     *
     * @param      $event
     * @param      $data
     * @param null $user_id
     */
    public function logEvent( $event, $data = null, User $user = null )
    {

        if ( ! in_array( $event, self::EVENTS ) ) {
            throw new \UnexpectedValueException( 'Event "' . $event . '" does not exist. Please correct, or add it to Amplitude wrapper.' );
        }

        session()->push( self::SESSION_VAR, [
            'event' => $event,
            'data'  => $data,
            'user'  => $user ? new UserRessource( $user ) : null
        ] );
    }

    /**
     * Get events that are stored in sessions and delete them from session.
     * Mostly use in the front-end to log events that happened in the back-end.
     */
    public function getEvents()
    {
        return session()->pull( self::SESSION_VAR ) ?: [];
    }

}