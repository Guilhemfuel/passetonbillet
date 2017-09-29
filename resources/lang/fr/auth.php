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

    'failed'   => 'Aucun utilisateur trouvé avec ces identifiants.',
    'throttle' => 'Trop de tentatives de connexion. Veuillez essayer de nouveau dans :seconds secondes.',
    'register' => [
        'title'                  => 'Inscription',
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
        'email'                  => 'Adresse e-mail',
        'password'               => 'Mot de passe',
        'password_confirm'       => 'Confirmation mot de passe',
        'already_registered'     => 'Déjà inscrit ? Cliquez-ici pour vous connecter.',
        'success_email_redirect' => 'Bienvenue parmi nous! Une dernière petite étape: nous vous avons envoyé un email de confirmation d\'inscription. Cliquez sur le lien contenu dans ce message pour activer votre compte. 
                                     <br>Pensez à vérifier dans vos spams!'
    ],
    'auth'     => [
        'title'              => 'Connexion',
        'email'              => 'Adresse e-mail',
        'password'           => 'Mot de passe',
        'remember_me'        => 'Se rappeler de moi',
        'not_registered_yet' => 'Pas encore inscrit? Cliquez pour vous inscrire.'
    ]

];
