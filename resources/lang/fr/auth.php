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

    'failed'       => 'Aucun utilisateur trouvé avec ces identifiants.',
    'throttle'     => 'Trop de tentatives de connexion. Veuillez essayer de nouveau dans :seconds secondes.',
    'common'       => [
        'about' => 'À propos',
        'contact' => 'Contact',

        'source' => [
            'sell' => 'Pour revendre un billet de train sur notre site, vous devez vous indentifier et créer un compte. La sécurité et la verification des billets sont essentielles sur PasseTonBillet.fr. ',
            'buy'  => 'Pour acheter un billet de train sur notre site, vous devez vous indentifier et créer un compte. La sécurité et la verification des billets sont essentielles sur PasseTonBillet.fr. ',
        ]
    ],
    'register'     => [
        'title'                  => 'Inscription',
        'manually'               => 'Inscription Manuelle',
        'first_name'             => 'Prénom',
        'last_name'              => 'Nom',
        'birthdate'              => 'Date de naissance',
        'gender'                 => [
            'title'  => 'Genre',
            'male'   => 'Homme',
            'female' => 'Femme'
        ],
        'location'               => [
            'title'       => 'Lieu de résidence',
            'placeholder' => 'Ex: Paris'
        ],
        'phone'                  => 'Téléphone',
        'language'               => 'Langue préférée',
        'email'                  => 'E-mail',
        'password'               => 'Mot de passe',
        'password_confirm'       => 'Confirmation du mot de passe',
        'already_registered'     => 'Déjà inscrit ? Cliquez-ici pour vous connecter.',
        'success_email_redirect' => 'Dernière étape! Veuillez consulter vos mails et cliquer sur le lien d\'activation que nous venons de vous envoyer.
                                     <br>Pensez à vérifier dans vos spams!',
        'token_no_user'          => 'Whoops! Nous n\'avons trouvé aucun utilisateur correspondant à ce lien... Si le problème persiste, contactez-nous.',
        'account_confirmed'      => 'Félicitations! Votre compte est maintenant activé. Vous pouvez à présent vous connecter en cliquant <a href="' . route( 'login.page' ) . '">ici</a> !',
        'fb_register'            => 'Inscription avec Facebook',


        'ticketLinkMessage' => 'Inscrivez vous sur PasseTonBillet.fr pour acheter et vendre des billets de trains européens de manière sécurisée, rapide, et économe.'

    ],
    'auth'         => [
        'title'              => 'Connexion',
        'email'              => 'Adresse e-mail',
        'password'           => 'Mot de passe',
        'remember_me'        => 'Se rappeler de moi',
        'not_registered_yet' => 'Pas encore inscrit? Cliquez pour vous inscrire.',
        'not_confirmed'      => 'Votre compte n\'est pas encore activé. Vérifiez vos emails et cliquez sur le lien d\'activation.',
    ],
    'reset'        => [
        'title'    => 'Mot de passe oublié',
        'question' => 'Mot de passe oublié? Cliquez-ici',
        'submit'   => 'Re-initialiser le mot de passe'
    ],
    'new_password' => [
        'title'  => 'Nouveau mot de passe',
        'submit' => 'Sauver le mot de passe'
    ],
    'social'       => [
        'last_step_pwd' => 'Une dernière petite étape: créer votre mot de passe pour confirmer votre inscription.',
        'email_used'    => 'Cette addresse email est déjà utilisée. Si c\'est vous, utilisez votre email et votre mot de passe pour vous connecter..',
        'success'       => 'Bienvenue parmi nous! Vous pouvez désormais acheter ou vendre des billets!'
    ]

];
