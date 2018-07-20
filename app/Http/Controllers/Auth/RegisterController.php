<?php

namespace App\Http\Controllers\Auth;

use App\Events\RegisteredEvent;
use App\User;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;


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
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        return view( 'auth.auth', [ 'type' => 'register' ] );
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
            'first_name'    => 'required|max:255',
            'last_name'     => 'required|max:255',
            'birthdate'     => 'date_format:d/m/Y|nullable',
            'gender'        => 'int',
            'location'      => 'string|nullable',
            'email'         => 'required|email|max:255|unique:users',
            'password'      => 'required|min:8|confirmed',
        ] );
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
            'first_name'     => $data['first_name'],
            'last_name'      => $data['last_name'],
            'birthdate'      => isset($data['birthdate']) ? \AppHelper::dbDate( $data['birthdate'] ):null,
            'language'       => strtoupper(session('applocale')),
            'gender'         => isset($data['gender'])?$data['gender']:null,
            'location'       => isset($data['location'])?$data['location']:null,
            'email'          => $data['email'],
            'password'       => bcrypt( $data['password'] ),
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
        $user = $this->create( $request->all() );

        // Registered event triggered (used for email verification...)
        event( new RegisteredEvent( $user ) );

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

        return redirect()->route( $this->redirectRoute );
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
        $user->status = 1;
        $user->email_token = null;
        if ( $user->save() ) {
            flash( __( 'auth.register.account_confirmed' ) )->success()->important();
            return redirect()->route('home');
        } else {
            flash( __( 'common.error' ) )->error()->important();
            return redirect()->route('home');
        }
    }

//     ======== Social Media Connect ===========

    /**
     * Ask facebook for authorization
     */
    public function fb_redirect(){
        return Socialite::driver('facebook')->fields([
            'first_name', 'last_name', 'email', 'gender', 'birthday','locale','picture'
        ])->scopes([
            'email', 'user_birthday'
        ])->redirect();
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
                'birthday',
                'locale',
                'picture'
            ] )->user();
        } catch (\Exception $e){
            flash(__('common.error'))->error();
            return redirect()->route('register.page');
        }

        $user = User::where('fb_id', $providerUser['id'])->first();
        if ($user){
            auth()->login($user, true);
            return redirect()->route('home');
        }

        // If fb id doesn't exist in db, we are going to create it, so we make sure that email isn't used
        $user = User::withTrashed()->where('email', $providerUser->user['email'])->first();
        if ($user){
            flash()->error(__('auth.social.email_used'))->important();
            return redirect()->route('login.page');
        }

        session()->put('fb_user',$providerUser);
        session()->put('fb_user_id',$providerUser['id']);
        session()->put('fb_user_created_at', Carbon::now() );

        return view('auth.social_password')->with('user',$providerUser);
    }

    /**
     * Once a user set a password to his account, it creates the user and log him in
     */
    public function fb_confirm_inscription(Request $request)
    {
        // If validation error redirect to register page
        $validator = Validator::make($request->all(), [
            'password'      => 'required|min:8|confirmed',
        ]);
        if ($validator->fails()) {
            return redirect()
                ->route('register.page')
                ->withErrors($validator);
        }

        $userData = session()->pull('fb_user');
        // We make sure data was retrieved from facebook less than 10 minutes ago
        $createdAt = session()->pull('fb_user_created_at');

        if (Carbon::now()->subMinutes(10)->greaterThan($createdAt)){
            flash()->error(__("common.error"))->important();
            return redirect()->route('register.page');
        }

        // Make sure email isn't already used
        $user = User::withTrashed()->where('email', $userData->user['email'])->first();
        if ($user){
            flash()->error(__('auth.social.email_used'))->important();
            return redirect()->route('login.page');
        }

        // Create user with an email already verified
        $user = User::make( [
            'first_name'     => $userData->user['first_name'],
            'last_name'      => $userData->user['last_name'],
            'birthdate'      => isset($userData->user['birthday']) ? \AppHelper::dbDate( $userData->user['birthday'] ):null,
            'language'       => strtoupper(session('applocale')),
            'gender'         => isset($userData->user['gender'])?($userData->user['gender']=='male'?1:0):null,
            'location'       => null,
            'email'          => $userData->user['email'],
            'picture'        => $userData->avatar
        ] );
        $user->email_verified = true;
        $user->status = 1;
        $user->email_token = null;
        $user->password = bcrypt( $request->password );
        $user->fb_id = session()->pull('fb_user_id');
        $user->save();

        // Registered event triggered (used for email verification...)
        event( new RegisteredEvent( $user ) );

        auth()->login($user);
        flash()->success(__('auth.social.success'));
        return redirect()->route('home');
    }

}
