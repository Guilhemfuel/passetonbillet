<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    'failed'   => 'These credentials do not match our records.',
    'throttle' => 'Too many login attempts. Please try again in :seconds seconds.',
    'register' => [
        'title'              => 'Register',
        'first_name'         => 'First Name',
        'last_name'          => 'Last Name',
        'birthdate'          => 'Birthdate',
        'gender'             => [
            'title'  => 'Gender',
            'male'   => 'Male',
            'female' => 'Female'
        ],
        'location'           => [
            'title'       => 'Location',
            'placeholder' => 'Eg: London'
        ],
        'phone'            => 'Phone Number',
        'language'         => 'Prefered language',
        'email'              => 'E-Mail Address',
        'password'           => 'Password',
        'password_confirm'   => 'Confirm password',
        'already_registered' => 'Already registered ? Click here to login.',
        'success_email_redirect' => 'Welcome! One more little step: we sent you an email to confirm your registration. Click on the link contained in the message to activate your account. 
                                     <br>If you don\'t find the email please check your junk mail folder.'
    ],
    'auth'     => [
        'title'              => 'Login',
        'email'              => 'E-Mail Address',
        'password'           => 'Password',
        'remember_me'        => 'Remember Me',
        'not_registered_yet' => 'Not registered yet? Click here to register.'
    ]

];
