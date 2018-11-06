<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Sms Language Lines
    |--------------------------------------------------------------------------
    */

    'title'                            => 'Mon profil',
    'account_verify'                   => 'Vérifier votre compte',
    'verification_pending'             => 'Vérification du profil en cours',
    'account_verified'                 => 'Identité vérifée',
    'change_password'                  => 'Changer le mot de passe',
    'change_picture'                   => 'Changer la photo de profil',
    'change_name'                      => 'Changer votre nom',
    'edit_profile'                     => 'Modifier les autres informations',
    'member_since'                     => 'Membre depuis le ',
    'number_tickets_successfully_sold' => 'Ticket(s) vendus avec succès',
    'by'                               => 'par',
    'only_you'                         => 'Informations privées du profil',


    'stats_title' => 'Statistiques',

    'modal' => [
        'change_name' => [
            'title'=> 'Changement de nom',
            'content' => 'Votre nom est automatiquement corrigé lors de la vérification de votre compte.</br><ul>
<li>Je n’ai pas encore demandé une vérification de mon compte: Si vous n’avez pas vérifié votre compte, merci de le faire en cliquant sur le bouton ‘Vérifier mon compte’. Votre nom sera automatiquement corrigé. </li>
<li>La vérification de mon compte est en cours: Si vous avez déjà soumis une copie d’un de vos documents d’identité pour la vérification de votre compte, merci de patienter. La vérification est généralement faite sous quelques minutes (maximum 24 heures). Votre nom sera automatiquement modifié lors de la vérification. (Merci de nous contacter dans le live chat à ce sujet qu\'en cas d\'urgence) </li>
<li>Mon compte est déjà vérifié mais mon nom est toujours incorrect: dans ce cas là, merci de nous contacter dans le live chat. Nous allons corriger cela immédiatement.</li></ul>'
        ],
        'edit_profile'    => [
            'title'   => 'Modifier votre profil',
            'content' => 'Pour corriger ou mettre à jour une information de votre profil autre que votre nom, contactez un membre de l\'équipe Ptb. Pour cela, cliquez sur le chat en bas à droite de votre écran, ou sur le bouton ci-dessous.',
            'cta'     => 'Contactez-nous!'
        ],
        'change_password' => [
            'title'     => 'Modifier le mot de passe',
            'component' => [
                'password'         => 'Mot de passe',
                'new_password'     => 'Nouveau mot de passe',
                'old_password'     => 'Mot de passe actuel',
                'password_confirm' => 'Confirmation du mot de passe'
            ],
            'cta'       => 'Changer le mot de passe',
            'flash'     => [
                'wrong_old_password' => 'Le mot de passe actuel indiqué n\'est pas le bon.',
                'success'            => 'Votre mot de passe a été mis à jour!'
            ]
        ],
        'change_picture'  => [
            'title'   => 'Modifier votre photo de profil',
            'text'    => 'Téléchargez une nouvelle photo de profil',
            'cta'     => 'Envoyer la photo',
            'error'   => 'Il y a une erreur lors de l\'upload de la photo. Essayez encore! Merci de nous contacter si le problème persiste.',
            'success' => 'Super! Votre photo de profil a été mise à jour.'
        ],
        'verify_identity' => [
            'title'      => 'Vérification d\'identité',
            'text'       => 'Afin d’assurer une sécurité maximum pour nos utilisateurs, vous devez vérifier la conformité de votre profil en nous envoyant une photo ou un scan d’une de vos pièces d’identité.',
            'list_title' => 'Pièces d\'identité acceptées',
            'list_id'    => [
                'passport'        => 'Passeport',
                'id_card'         => 'Carte d\'identité',
                'driving_license' => 'Permis de conduire'
            ],
            'country'    => 'Pays d\'émission du document',
            'type'       => 'Type de document',
            'cta'        => 'Vérifier mon identité',
            'delay'      => 'La verification se fait généralement sous 24 heures, mais vous pourrez vendre un billet dès l\'upload de votre pièce d\'identité.',
            'error'      => 'Il y a une erreur lors de l\'upload de votre piẻce d\'identité. Si le problème persiste, contactez-nous!',
            'success'    => 'Votre pièce d\'identité a bien été uploadé. Votre compte devrait être mis à jour sous 24h!'
        ]
    ]
];
