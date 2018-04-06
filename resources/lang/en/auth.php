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

    'failed'       => 'These credentials do not match our records.',
    'throttle'     => 'Too many login attempts. Please try again in :seconds seconds.',
    'register'     => [
        'title'                  => 'Register',
        'manually'               => 'Register manually',
        'first_name'             => 'First Name',
        'last_name'              => 'Last Name',
        'birthdate'              => 'Birthdate',
        'gender'                 => [
            'title'  => 'Gender',
            'male'   => 'Male',
            'female' => 'Female'
        ],
        'location'               => [
            'title'       => 'Location',
            'placeholder' => 'Eg: London'
        ],
        'phone'                  => 'Phone Number',
        'language'               => 'Prefered language',
        'email'                  => 'E-Mail Address',
        'password'               => 'Password',
        'password_confirm'       => 'Confirm password',
        'already_registered'     => 'Already registered ? Click here to login.',
        'success_email_redirect' => 'Last step! Please check your mails and click on the activation link we just sent you. 
                                     <br>If you don\'t find the email please check your junk mail folder.',
        'token_no_user'          => 'Whoops! We didn\'t find any user corresponding to this link... If the issue persist please contact us.',
        'account_confirmed'      => 'Congratulations! Your account is now activated. You can already login by clicking <a href="' . route( 'login.page' ) . '">here</a> !',
        'fb_register' => 'Register with Facebook',

        'ticketLinkMessage' => 'Register now on Lastar to be able to buy and sell Eurostar tickets in a safe, quick, and cheap way.'
    ],
    'auth'         => [
        'title'              => 'Login',
        'email'              => 'E-Mail Address',
        'password'           => 'Password',
        'remember_me'        => 'Remember Me',
        'not_registered_yet' => 'Not registered yet? Click here to register.',
        'not_confirmed'      => 'Your account is not confirmed yet. Check your emails and click the link to activate it.',
    ],
    'reset'        => [
        'title'    => 'Reset password',
        'question' => 'Password forgotten? Click here',
        'submit'   => 'Reset password'
    ],
    'new_password' => [
        'title'  => 'New Password',
        'submit' => 'Save new password'
    ],
    'social'       => [
        'last_step_pwd' => 'One last step before you can access your account: set a password!',
        'email_used'    => 'A user is already using this email address. If it\'s you please login using your email and password.',
        'success'       => 'Welcome! You can now buy or sell tickets!'
    ]

];
