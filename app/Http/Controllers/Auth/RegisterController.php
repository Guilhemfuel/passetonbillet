<?php

namespace App\Http\Controllers\Auth;

use App\Events\RegisteredEvent;
use App\User;
use App\Http\Controllers\Controller;
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
    protected $redirectTo = '/';

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        return view( 'auth.auth', [ 'type' => 'register' ] );
    }

//    public function fb_redirect(){
//        return Socialite::driver('facebook')->fields([
//            'first_name', 'last_name', 'email', 'gender', 'birthday'
//        ])->scopes([
//            'email', 'user_birthday'
//        ])->redirect();
//    }
//
//    public function fb_callback()
//    {
//        $providerUser = \Socialite::driver('facebook')->user();
//        print_r($providerUser);
//    }

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
            'birthdate'     => 'date',
            'language'      => 'in:FR,EN',
            'gender'        => 'int',
            'location'      => 'string|nullable',
            'phone_country' => 'in:EN,BE,FR|required',
            'phone'         => 'required',
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
        return User::create( [
            'first_name'    => $data['first_name'],
            'last_name'     => $data['last_name'],
            'birthdate'     => \AppHelper::dbDate($data['birthdate']),
            'language'      => $data['language'],
            'gender'        => $data['gender'],
            'location'      => $data['location'],
            'phone_country' => $data['phone_country'],
            'phone'         => $data['phone'],
            'email'         => $data['email'],
            'password'      => bcrypt( $data['password'] ),
            'status'        => 0,
            'email_verified'=> false,
            'email_token'   => bcrypt( str_random(random_int(1,100) ).$data['email'].str_random(random_int(1,100) ) )
        ] );
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        // Registered event triggered (used for email verification...)
        event(new RegisteredEvent($user = $this->create($request->all())));

        return $this->registered($request, $user);
    }

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        \Session::put('applocale', strtolower($user->language));

        flash( __('auth.register.success_email_redirect') )->success()->important();
        return redirect()->route('home');
    }
}
