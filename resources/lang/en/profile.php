<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Sms Language Lines
    |--------------------------------------------------------------------------
    */

    'title'                            => 'My profile',
    'account_verify'                   => 'Verify my account',
    'verification_pending'             => 'Account Verification Pending',
    'account_verified'                 => 'Identity verified',
    'change_password'                  => 'Change password',
    'change_name'                      => 'Change your name',
    'edit_profile'                     => 'Edit your information',
    'change_picture'                   => 'Change profile picture',
    'member_since'                     => 'Member since ',
    'number_tickets_successfully_sold' => 'Ticket(s) successfully sold',
    'by'                               => 'by',
    'only_you'                         => 'Private profile information',
    'delete_account'                   => 'Delete my account',

    'stats_title' => 'Statistics',

    'modal' => [
        'change_name'     => [
            'title'   => 'Name change',
            'content' => 'Your name is automatically corrected when your account is verified.</br><ul>
<li>I have not yet requested a verification for my account: If you have not verified your account, please do so by clicking on the \'Verify my account\'. Your name will automatically be corrected.</li>
<li>The verification of my account is in progress: If you have already submitted a copy of one of your identity documents for the verification of your account, please wait. The verification is usually done within a few minutes (maximum 24 hours). Your name will automatically be corrected once the verification process will be completed. (Please contact us in the live chat only in case of emergency)</li>
<li>My account is already verified but my name is still incorrect: in that case, please contact us via the live chat. We will correct it for you.</li></ul>'
        ],
        'edit_profile'    => [
            'title'   => 'Edit your profile',
            'content' => 'If you want to edit some information on your profile, other than your name, please contact us using the live chat tool on the bottom right corner of your screen, or by clicking on the button below.',
            'cta'     => 'Contact us!'
        ],
        'change_password' => [
            'title'     => 'Change password',
            'component' => [
                'password'         => 'Password',
                'new_password'     => 'New password',
                'old_password'     => 'Current password',
                'password_confirm' => 'Confirm password '
            ],
            'cta'       => 'Change password',
            'flash'     => [
                'wrong_old_password' => 'Incorrect current password.',
                'success'            => 'Your password was updated!'
            ]
        ],
        'change_picture'  => [
            'title'   => 'Edit your profile picture',
            'text'    => 'Upload a new profile picture',
            'cta'     => 'Submit your document',
            'error'   => 'An error occurred when we tried to upload your picture. Please try again.  Contact us if the problem persists.',
            'success' => 'Amazing! Your profile picture was updated.'
        ],
        'verify_identity' => [
            'title'      => 'Identity check',
            'text'       => 'In order to guarantee an optimal level of security for our users, you must upload a picture or a scan of one of your identity documents to have your profile verified.',
            'list_title' => 'Identification documents accepted',
            'list_id'    => [
                'passport'        => 'Passport',
                'id_card'         => 'ID card',
                'driving_license' => 'Driving license'
            ],
            'country'    => 'Country of issue',
            'type'       => 'Type of document',
            'cta'        => 'Verify my identity',
            'delay'      => 'The identity verification usually takes place within 24 hours, but you\'ll be able to sell a ticket as soon as you uploaded it.',
            'error'      => 'An error occurred when we tried to download your identity document. Please try again. Contact us if the problem persists.',
            'success'    => 'Your identity document was successfully downloaded. Your account should be verified within 24 hours!'
        ],
        'delete_account'  => [
            'text'    => 'Do you really wish to delete your PasseTonBillet account? Your profile as well as your sale history, your tickets, your discussions, and your messages will be deleted. This action cannot be cancelled.',
            'cta'     => 'Confirm account deletion',
            'cancel'  => 'Whoops! I want to keep my account',
            'success' => 'Account successfully deleted. Please contact us to give feedback. We hope to see you again soon on PasseTonBillet !'
        ]
    ]
];
