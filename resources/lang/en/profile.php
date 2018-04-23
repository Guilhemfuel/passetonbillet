<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Sms Language Lines
    |--------------------------------------------------------------------------
    */

    'title' => 'My profile',
    'account_verify' => 'Verify my account',
    'account_verified' => 'Identity verified',
    'change_password' => 'Change password',
    'edit_profile' => 'Edit your information',
    'change_picture' => 'Change profile picture',
    'member_since' => 'Member since ',
    'number_tickets_successfully_sold' => 'Tickets successfully sold',
    'by' => 'by',

    'stats_title' => 'Statistics',

    'modal' => [
        'edit_profile' => [
            'title' => 'Edit your profile',
            'content' => 'If you want to edit some information on your profile, please contact us using the live chat tool on the bottom right corner of your screen, or by clicking on the button below.',
            'cta' => 'Contact us!'
        ],
        'change_password' => [
            'title' => 'Change password',
            'component' => [
                'password' => 'Password',
                'new_password' => 'New password',
                'old_password' => 'Current password',
                'password_confirm' => 'Confirm password '
            ],
            'cta' => 'Change password',
            'flash'=> [
                'wrong_old_password' => 'Incorrect current password.',
                'success' => 'Your password was updated!'
            ]
        ],
        'change_picture' => [
            'title' => 'Edit your profile picture',
            'text' => 'Upload a new profile picture',
            'cta' => 'Submit your document',
            'error' => 'An error occurred when we tried to upload your picture. Please try again.  Contact us if the problem persists.',
            'success' => 'Amazing! Your profile picture was updated.'
        ],
        'verify_identity' => [
            'title' => 'Identity check',
            'text' => 'In order to guarantee an optimal level of security for our users, you must upload a picture or a scan of one of your identity documents to have your profile verified.',
            'list_title' => 'Identification documents accepted',
            'list_id' => [
                'passport' => 'Passport',
                'id_card' => 'Identity card',
                'driving_license' => 'Driving license'
            ],
            'cta' => 'Verify my identity',
            'delay' => 'The identity verification usually takes place within 24 hours, but you\'ll be able to sell a ticket as soon as you uploaded it.',
            'error' => 'An error occurred when we tried to download your identity document. Please try again. Contact us if the problem persists.',
            'success' => 'Your identity document was successfully downloaded. Your account should be verified within 24 hours!'
        ]
    ]
];
