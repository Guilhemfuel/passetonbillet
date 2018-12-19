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
    'common'       => [
        'contact' => 'Contact us',
        'help'    => 'Help',

        'source' => [
            'sell'     => 'You must create an account before selling a ticket on our website. Safety and ticket verification are very important on PasseTonBillet.fr.',
            'buy'      => 'You must create an account before buying a ticket on our website. Safety and ticket verification are very important on PasseTonBillet.fr.',
            'fb_title' => '100% Free, Fast and Secure',
            'fb'       => 'Put your ticket for sale <b>now</b> on PasseTonBillet.fr and receive a <b>personalized link</b> to share it on facebook groups !'
        ]
    ],
    'register'     => [
        'title'                  => 'Register',
        'title_ticket'           => 'Register to buy this ticket',
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
        'email'                  => 'E-Mail',
        'password'               => 'Password',
        'password_confirm'       => 'Confirm password',
        'already_registered'     => 'Already registered ? Click here to login.',
        'success_email_redirect' => 'Last step! Please check your mails and click on the activation link we just sent you. 
                                     <br>If you don\'t find the email please check your junk mail folder.',
        'token_no_user'          => 'Whoops! We didn\'t find any user corresponding to this link... If the issue persist please contact us.',
        'account_confirmed'      => 'Congratulations! Your account is now activated. You can already login by clicking <a href="' . route( 'login.page' ) . '">here</a> !',
        'fb_register'            => 'Register with Facebook',
        'cgu'                    => 'I have read and accept the <a href="' . route( 'cgu.page' ) . '" target="blank" >general terms and conditions</a>.',

        'ticketLinkMessage' => 'Register now on PasseTonBillet.fr to be able to buy and sell European trains tickets in a safe, quick, and cheap way.',

        'deny_location' => 'We currently do not accept new registration. Please try again in a few days.'
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
        'last_step_pwd' => 'One last step before you can access your account: verify your information ands set a password!<br><br>
          Please make sure that your <b>real name</b> is below as it will be used to check your tickets. We will also <b>send your notifications to the email address</b> filled below !',
        'email_used'    => 'A user is already using this email address. If it\'s you please login using your email and password.',
        'success'       => 'Welcome! Last step to confirm your account: Your <b>check your emails</b> and <b>click the link to activate it</b>.'
    ]

];
