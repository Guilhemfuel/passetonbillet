<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Nav Language Lines
    |--------------------------------------------------------------------------
    */

    'component' => [
        'buy'                    => 'Acheter',
        'sell'                   => 'Vendre ce billet',
        'sold_by'                => 'Publié il y a {{days}} par',
        'edit'                   => 'Modifier',
        'edit_ticket'            => 'Modifier le billet',
        'buy_ticket'             => 'Acheter le billet',
        'your_offer'             => 'Votre offre',
        'price'                  => 'Prix',
        'send_offer'             => 'Envoyer l\'offre',
        'if_interested'          => 'Le vendeur vous contactera s\'il est interessé.',
        'infos'                  => 'Infos',
        'booking_code'           => 'Numéro de réservation',
        'booking_name'           => 'Nom de réservation',
        'delete'                 => 'Vous ne voulez plus vendre ce billet?',
        'share'                  => 'Lien de partage du billet',
        'copied'                 => 'Lien copié dans le presse-papier.',
        'delete_cta'             => 'Retirer le billet',
        'offer_sent'             => 'Le vendeur a bien reçu votre offre! Il vous recontactera si il est interessé.',
        'register'               => 'La sécurité est notre premier soucis. Ainsi, vous devez etre inscrit pour commnuniquer avec les autres membres.',
        'register_cta'           => 'Inscrivez-vous pour envoyer votre offre!',
        'user_verified'          => 'Nous avons vérifié l\'identité de cet utilisateur.',
        'discuss'                => 'Discuster',
        'new_offer'              => 'Nouvelle Offre',
        'download_ticket'        => 'Télécharger le billet',
        'download'               => 'Télécharger',
        'eurostar_ticket_number' => 'Numéro du billet',

        'status' => [
            'awaiting' => 'En Attente',
            'accepted' => 'Acceptée',
            'refused'  => 'Refusée'
        ],

    ],
    'sell'      => [
        'title'         => 'Vendre un billet',
        'description'   => 'Vendre un billet est très simple et très rapide. Tout ce que vous avez à faire est d\'entrer votre nom de famille ainsi que votre numéro de réservation. Tous les tickets correspondants à cette reservation vont alors aparaître et vous n\'aurez plus qu\'à séléctionner ceux que vous souhaitez mettre en vente.',
        'inputs'        => [
            'last_name'    => 'Nom de famille associé à la reservation',
            'booking_code' => 'Référence de réservation, ex: QNUSHT',
            'price'        => 'Prix de vente',
            'notes'        => 'Vous pouvez écrire ici une description pour ce billet...'
        ],
        'search'        => 'Chercher le(s) billet(s)',
        'other_name'    => 'Contactez-nous pour vendre un billet associé à un autre nom.',
        'searching'     => 'Recherche de vos billets...',
        'your_tickets'  => 'Vos billets',
        'select'        => 'Hooray ! Nous avons trouvé vos billets. Selectionnez le billet que vous souhaitez vendre.',
        'details_title' => 'Information du billet',
        'details'       => 'Nous avons presque terminé! Il ne vous reste qu\'à indiquer votre prix. Le prix de vente ne peut pas excéder le prix originel d\'achat. Vous pouvez prévisualiser vos changement directement sur le billet.',
        'submit'        => 'Vendre le billet',
        'preview'       => 'Prévisualisation du billet',
        'errors'        => [
            'max_value' => 'Whoops ! Le prix de revente ne peut être supérieur au prix d\'achat ! Essayez encore avec un prix plus bas.',
            'duplicate' => 'Whoops ! Ce billet a déjà été mis en vente...',
            'search'    => 'Whoops ! Aucun billet trouvé... Essayez à nouveau, et si le problème persiste, contactez-nous.'
        ],
        'success'       => 'Hooray! Votre billet est maintenant disponible à l\'achat ! Merci de votre confiance !',

        'confirm_number' => [
            'last_step'        => 'Une dernière petite étape! Parce que la sécurité est notre mission numéro une, vous devez renseigner votre numéro de téléphone avant de pouvoir vendre un billet. Vous allez recevoir un SMS de confirmation dans les prochaines secondes. Et vous pourrez vendre votre billet!',
            'code_check'       => ' Renseignez le code que nous vous avons envoyé par sms pour confirmer votre numéro de téléphone. Vous pourrez ensuite commencer à vendre des billets.',
            'CTA'              => 'Vérifier mon numéro',
            'no_code_received' => 'Vous n\'avez pas reçu de code de vérificaiton? Cliquez-ici',

            'errors'  => [
                'phone_already_used'     => 'Numéro déjà enregistré par un autre utilisateur. Merci de nous contacter si le problème persiste.',
                'phone_already_verified' => 'Votre numéro de téléphon est déjà vérifié! Contactez-nous pour si vous souhaitez le changer.',
                'verify_max_retry'       => 'Vous avez déjà essayer de vérifier votre numéro de téléphone 3 fois sans réussite. Merci de nous contacter pour résoudre le problème.',
                'no_verification_found'  => 'Code de vérification invalide, merci de nous contacter si le problème persiste.',
            ],
            'success' => [
                'code_sent'        => 'Un code vérification vous a été envoyé par SMS.',
                'number_confirmed' => 'Féliciation! Votre numéro de téléphone est confirmé. Vous pouvez vendre vos tickets immédiatement!'
            ]
        ],

        'manual' => [
            'link' => 'Vous n\'avez pas de numéro de réservation? Cliquer ici pour rentrer les informations de votre billet manuellement.',
            'title' => 'Ajout Manuel de Billet',
            'fail_retrieval' => [
                'title' => 'Aucun résultat trouvé pour votre combinaison nom/réservation.',
                'message' => 'Malheuresment, nous n\'avons trouvé aucun billet. Vous pouvez ajoutez votre billet manuellement ici. Cliquez sur ce message pour essayer de trouver votre billet à l\'aide de votre numéro de réservation.'
            ],
            'text' => "Si vous souhaitez vendre un billet cartonné, ou que nous n'avons pas pu retrouver votre billet, il vous suffit de remplir ce formulaire.",
            'back_link' => 'Vous avez votre numéro de réservation? Cliquez ici pour retrouver votre billet automatiquement.',
            'form' => [
                'title_travel' => 'Informations sur le voyage',
                'departure_station' => 'Gare de départ',
                'arrival_station' => 'Gare d\'arrivée',
                'travel_date' => 'Date de voyage',
                'train_number' => 'Numéro de train',
                'departure_time' => "Heure de Départ",
                'arrival_time' => "Heure d'Arrivée",
                'title_ticket' => 'Informations sur le billet',
                'company' => 'Agence ferroviaire',
                'flexibility' => 'Tarif',
                'classe' => 'Classe',
                'currency' => 'Devise',
                'bought_price' => 'Prix d\'achat',
                'price' => 'Prix de vente'

            ]
        ]
    ],
    'buy'       => [
        'inputs'         => [
            'trippicker'     => [
                'departure_station' => 'Gare de départ',
                'arrival_satation'  => 'Gare d\'arrivée',
            ],
            'datetimepicker' => [
                'trip_date' => 'Date du voyage',
                'trip_time' => 'À partir de (Optionnel)'
            ],
            'homepicker' => [
                'depart' => 'Départ',
                'arrival' => 'Arrivée'
            ]
        ],
        'title'          => 'Acheter un billet',
        'catchline'      => 'Quel est votre trajet?',
        'research'       => 'Rechercher',
        'search_result'  => 'ticket(s) correspondent à votre recherche.',
        'safety'         => 'La sécurité est notre priorité numéro 1. Vous devez vous inscrire pour vendre un billet.',
        'create_account' => 'Inscrivez-vous et envoyez votre offre!'
    ],
    'owned'     => [
        'no_bought_tickets'      => 'Vous n\'avez pas encore acheté de billet!',
        'no_bought_tickets_cta'  => 'Cliquez-ici pour acheter un billet.',
        'no_sold_tickets'        => 'Vous n\'avez pas encore vendu de billet!',
        'no_sold_tickets_cta'    => 'Cliquez-ici pour mettre un billet en vente.',
        'no_selling_tickets'     => 'Vous n\'avez pas encore de billet en vente!',
        'no_selling_tickets_cta' => 'Cliquez-ici pour mettre un billet en vente.',
        'no_offered_tickets'     => 'Vous n\'avez pas encore envoyé d\'offres!',
        'no_offered_tickets_cta' => 'Cliquez-ici pour acheter un billet.',
        'bought'                 => 'Acheté(s)',
        'sold'                   => 'Vendu(s)',
        'selling'                => 'En vente',
        'offers_sent'            => 'Offres envoyées',

    ],
    'delete'    => [
        'success' => 'Votre ticket a bien été supprimé.'
    ],
    'errors'    => [
        'passed' => 'Ce ticket est déjà passé! Cherchews'
    ]


];
