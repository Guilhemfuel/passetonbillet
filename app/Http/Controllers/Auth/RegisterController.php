<?php

namespace App\Http\Controllers\Auth;

use App\Events\RegisteredEvent;
use App\Facades\AppHelper;
use App\Models\Statistic;
use App\Notifications\WelcomeNotification;
use App\User;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Laravel\Socialite\Two\InvalidStateException;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    const SOURCE_GUEST_SELL = 'guest-sell';
    const SOURCE_GUEST_OFFER = 'guest-offer';
    const SOURCE_FB_GROUP = 'group-fb';
    const SOURCE_TICKET_PREVIEW = 'ticket-preview';

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectRoute = 'login.page';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware( 'guest' );
    }

    /**
     * Get redirect route after login depending on user source or other attributes.
     */
    public function redirectRoute( $user )
    {
//        if ( session()->has( 'register-source' ) ) {
//            $source = session()->get('register-source');
//        } else {
//            $source = $user->stats()->where('action','register')->first();
//            $source = $source->data['source'];
//        }

        return $this->redirectRoute;
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm( Request $request )
    {
        $possibleSources = [
            self::SOURCE_GUEST_SELL,
            self::SOURCE_GUEST_OFFER,
            self::SOURCE_FB_GROUP,
            self::SOURCE_TICKET_PREVIEW
        ];

        $source = null;

        if ( $request->has( 'source' ) && in_array( $request->source, $possibleSources ) ) {
            $source = $request->source;
            session( [ 'register-source' => $request->source ] );
            AppHelper::pageStat('register',$source);
        } else {
            AppHelper::pageStat('register');
        }

        return view( 'auth.auth', [ 'type' => 'register', 'source' => $source ] );
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator( array $data )
    {
        return Validator::make( $data, [
            'first_name' => 'required|max:255',
            'last_name'  => 'required|max:255',
            'birthdate'  => 'date_format:d/m/Y|nullable',
            'gender'     => 'int',
            'location'   => 'string|nullable',
            'email'      => 'required|email|max:255|unique:users',
            'password'   => 'required|min:8|confirmed',
            'cgu'        => 'required|accepted'
        ] );
    }

    /**
     * Only accepts requests from Europe
     */
    public function checkCountryOfRequest( Request $request )
    {
        $information = geoip( $request->ip() );

        $forbiddenCountries = [ 'Ivory Coast' ];

        if ( in_array( $information['country'], $forbiddenCountries ) ) {
            return false;
        }

        return true;
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     *
     * @return User
     */
    protected function create( array $data )
    {
        $user = User::create( [
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
            'birthdate'  => $data['birthdate'],
            'language'   => strtoupper( session( 'applocale' ) ),
            'gender'     => isset( $data['gender'] ) ? $data['gender'] : null,
            'location'   => isset( $data['location'] ) ? $data['location'] : null,
            'email'      => $data['email'],
            'password'   => bcrypt( $data['password'] ),
        ] );
        // Create email verify token and set default status
        $user->status = 0;
        $user->email_token = str_random( random_int( 40, 100 ) );
        $user->save();

        return $user;
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function register( Request $request )
    {
        $this->validator( $request->all() )->validate();

        // Check location of IP for scammers
        if ( ! $this->checkCountryOfRequest( $request ) ) {

            flash( __( 'auth.register.deny_location' ) )->error();
            // Store event and IP
            \AppHelper::stat( 'location_denied', [
                'email' => $request->email,
                'ip_address' => $request->ip()
            ]);

            return redirect()->route( 'home' );
        }
        
        $user = $this->create( $request->all() );

        // Registered event triggered (used for email verification, logs...)
        $source = session()->pull('register-source', null);
        event( new RegisteredEvent( $user, $source, $request->ip() ) );

        return $this->registered( $request, $user );
    }

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  mixed                    $user
     *
     * @return mixed
     */
    protected function registered( Request $request, $user )
    {
        \Session::put( 'applocale', strtolower( $user->language ) );

        flash( __( 'auth.register.success_email_redirect' ) )->success()->important();

        return redirect()->route( $this->redirectRoute( $user ) );
    }

    /**
     * Handle a email verification request.
     *
     * @param $token
     *
     * @return \Illuminate\Http\Response
     */
    public function verify( $token )
    {
        $user = User::where( 'email_token', $token )->first();
        // Case not user match
        if ( ! $user ) {
            flash( __( 'auth.register.token_no_user' ) )->error()->important();

            return redirect()->route( 'home' );
        }

        $user->email_verified = true;
        $user->status = User::STATUS_USER;
        $user->email_token = null;

        if ( $user->save() ) {

            // Send welcome email to user
            $user->notify( ( new WelcomeNotification() )->delay( now()->addMinutes( 5 ) ) );

            flash( __( 'auth.register.account_confirmed' ) )->success()->important();

            return redirect()->route( 'home' );
        } else {
            flash( __( 'common.error' ) )->error()->important();

            return redirect()->route( 'home' );
        }
    }

//     ======== Social Media Connect ===========

    /**
     * Ask facebook for authorization
     */
    public function fb_redirect()
    {
        return Socialite::driver( 'facebook' )->fields( [
            'first_name',
            'last_name',
            'email',
            'gender',
            'birthday',
            'locale',
            'picture'
        ] )->scopes( [
            'email',
        ] )->redirect();
    }

    /**
     * Retrieve facebook user info
     */
    public function fb_callback()
    {
        try {
            $providerUser = \Socialite::driver( 'facebook' )->fields( [
                'first_name',
                'last_name',
                'email',
                'gender',
                'locale',
                'picture'
            ] )->user();
        } catch ( \Exception $e ) {
            flash( __( 'common.error' ) )->error();

            return redirect()->route( 'register.page' );
        }

        $user = User::where( 'fb_id', $providerUser['id'] )->first();
        if ( $user ) {
            if ( ( $user->email_verified == true && $user->status == User::STATUS_USER ) || $user->status == User::STATUS_ADMIN ) {
                auth()->login( $user, true );
            } else {
                flash()->error( trans( 'auth.auth.not_confirmed' ) );
            }

            return redirect()->route( 'home' );
        }

        // If fb id doesn't exist in db, we are going to create it, so we make sure that email isn't used
        if ( isset( $providerUser->user['email'] ) ) {
            $user = User::withTrashed()->where( 'email', $providerUser->user['email'] )->first();
            if ( $user ) {
                flash()->error( __( 'auth.social.email_used' ) )->important();

                return redirect()->route( 'login.page' );
            }
        }

        session()->put( 'fb_user', $providerUser );
        session()->put( 'fb_user_id', $providerUser['id'] );
        session()->put( 'fb_user_created_at', Carbon::now() );

        return view( 'auth.social_password' )->with( 'user', $providerUser );
    }

    /**
     * Once a user set a password to his account, it creates the user and log him in
     */
    public function fb_confirm_inscription( Request $request )
    {

        // If validation error redirect to register page
        $validator = Validator::make( $request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'password' => 'required|min:8|confirmed',
            'email'    => 'required|email',
            'cgu'      => 'required|accepted'
        ] );
        if ( $validator->fails() ) {
            return redirect()
                ->route( 'register.page' )
                ->withErrors( $validator );
        }

        $userData = session()->pull( 'fb_user' );
        // We make sure data was retrieved from facebook less than 10 minutes ago
        $createdAt = session()->pull( 'fb_user_created_at' );

        if ( Carbon::now()->subMinutes( 10 )->greaterThan( $createdAt ) ) {
            flash()->error( __( "common.error" ) )->important();

            return redirect()->route( 'register.page' );
        }

        // Make sure email isn't already used
        $user = User::withTrashed()->where( 'email', $request->email )->first();
        if ( $user ) {
            flash()->error( __( 'auth.social.email_used' ) )->important();

            return redirect()->route( 'login.page' );
        }

        // Check location of IP for scammers
        if ( ! $this->checkCountryOfRequest( $request ) ) {
            flash( __( 'auth.register.deny_location' ) )->error();

            return redirect()->route( 'home' );
        }

        // Create user - now need for email account validation
        $user = User::make( [
            'first_name' => $request->get('first_name'),
            'last_name'  => $request->get('last_name'),
            'birthdate'  => isset( $userData->user['birthday'] ) ? \AppHelper::dbDate( $userData->user['birthday'] ) : null,
            'language'   => strtoupper( session( 'applocale' ) ),
            'gender'     => isset( $userData->user['gender'] ) ? ( $userData->user['gender'] == 'male' ? 1 : 0 ) : null,
            'location'   => null,
            'email'      => $request->email,
            'picture'    => $userData->avatar
        ] );
        $user->status = 0;
        $user->email_token = str_random( random_int( 40, 100 ) );
        $user->password = bcrypt( $request->password );
        $user->fb_id = session()->pull( 'fb_user_id' );
        $user->save();


        // Registered event triggered (used for email verification...)
        $source = session()->pull('register-source', null);
        event( new RegisteredEvent( $user, $source, $request->ip() ) );

        flash()->success( __( 'auth.social.success' ) );

        return redirect()->route( 'home' );
    }

}
