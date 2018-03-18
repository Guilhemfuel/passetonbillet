<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Sms Language Lines
    |--------------------------------------------------------------------------
    */

    'title' => 'Mon profil',
    'account_verify' => 'Vérifier votre compte',
    'account_verified' => 'Identité vérifée',
    'change_password' => 'Changer le mot de passe',
    'change_picture' => 'Changer la photo de profil',
    'edit_profile' => 'Modifier les informations',
    'member_since' => 'Membre depuis le ',

    'stats_title' => 'Statistiques',

    'modal' => [
        'edit_profile' => [
            'title' => 'Modifier votre profil',
            'content' => 'Pour corriger ou mettre à jour une information de votre profil, contactez un membre de l\'équipe Lastar. Pour cela, cliquez sur le chat en bas à droite de votre écran, ou sur le bouton ci-dessous.',
            'cta' => 'Contactez-nous!'
        ],
        'change_password' => [
            'title' => 'Modifier le mot de passe',
            'component' => [
                'password' => 'Mot de passe',
                'new_password' => 'Nouveau mot de passe',
                'old_password' => 'Mot de passe actuel',
                'password_confirm' => 'Confirmation du mot de passe'
            ],
            'cta' => 'Changer le mot de passe',
            'flash'=> [
                'wrong_old_password' => 'Le mot de passe actuel indiqué n\'est pas le bon.',
                'success' => 'Votre mot de passe a été mis à jour!'
            ]
        ],
        'change_picture' => [
            'title' => 'Modifier votre photo de profil',
            'text' => 'Téléchargez une nouvelle photo de profil',
            'cta' => 'Enregistrer la photo.',
            'error' => 'Il y a une erreur lors de l\'upload de la photo. Essayez encore! Merci de nous contacter si le problème persiste.',
            'success' => 'Super! Votre photo de profil a été mise à jour.'
        ],
        'verify_identity' => [
            'title' => 'Vérification d\'identité',
            'text' => 'Afin d’assurer une sécurité maximum pour nos utilisateurs, nous offrons la possibilité de vérifier la conformité de votre profil en nous envoyant un scan d’une de vos pièces d’identité.',
            'list_title' => 'Pièces d\'identité acceptées',
            'list_id' => [
                'passport' => 'Passeport',
                'id_card' => 'Carte d\'identité',
                'driving_license' => 'Permis de conduire'
            ],
            'cta' => 'Vérifier mon identité',
            'delay' => 'La verification se fait généralement sous 24 heures.',
            'error' => 'Il y a une erreur lors de l\'upload de votre piẻce d\'identité. Si le problème persiste, contactez-nous!',
            'success' => 'Votre pièce d\'identité a bien été uploadé. Votre compte devrait être mis à jour sous 24h!'
        ]
    ]
];
