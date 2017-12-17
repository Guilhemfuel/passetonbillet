<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Nav Language Lines
    |--------------------------------------------------------------------------
    */

    'component' => [
        'buy'     => 'Acheter',
        'sell'    => 'Vendre ce billet',
        'sold_by' => 'Vendu par',
        'edit'    => 'Modifier',
        'edit_ticket' => 'Modifier le billet'
    ],
    'sell'      => [
        'title'         => 'Vendre un billet',
        'description'   => 'Vendre un billet est très simple et très rapide. Nous avons uniquement besoin du numéro de réservation Eurostar, et du nom de famille associé à cette dernière. Nous chercherons vos billets, et vous pourrez choisir quel billet mettre en vente.',
        'inputs'        => [
            'last_name'    => 'Nom de famille d\'un passager',
            'booking_code' => 'Référence de réservation, ex: QNUSHT',
            'price'        => 'Selling price',
            'notes'        => 'Your can write notes here about this ticket...'
        ],
        'search'        => 'Chercher le(s) billet(s)',
        'searching'     => 'Recherche de vos billets...',
        'your_tickets'  => 'Vos billets',
        'select'        => 'Hooray ! Nous avons trouvé vos billets. Selectionnez le billet que vous desirez vendre.',
        'details_title' => 'Information du billet',
        'details'       => 'Nous avons presque terminé! Entrez votre prix, et si besoin, laissez une note attachée au billet. Le prix de vente ne peut pas excéder le prix originel d\'achat. Vous pouvez prévisualiser vos changement directement sur le billet.',
        'submit'        => 'Vendre le billet',
        'preview'       => 'Prévisualisation du billet',
        'errors'        => [
            'max_value' => 'Whoops ! Le prix de revente ne peut être supérieur au prix d\'achat !',
            'duplicate' => 'Whoops ! Ce billet a déjà été mis en vente...',
            'search'    => 'Whoops ! Aucun billet trouvé... Essayez à nouveau, et si le problème persiste, contactez-nous.'
        ],
        'success'       => 'Hooray! Votre billet est maintenant disponible à l\'achat ! Merci de votre confiance !',

        'confirm_number' => [
            'last_step'  => 'Une dernière petite étape! Parce que la sécurité est notre mission numéro une, vous
                                    devez renseigner votre numéro de téléphone avant de pouvoir vendre un billet. Nous
                                    vous enverrons un sms de confirmation. Et vous pourrez vendre votre billet!',
            'code_check' => ' Renseignez le code que nous vous avons envoyé par sms pour confirmer votre numéro de téléphone. Vous pourrez ensuite commencer à vendre des billets.',
            'CTA'        => 'Vérifier mon numéro',
            'no_code_received' => 'Vous n\'avez pas reçu de code? Cliquez-ici'
        ]
    ],
    'buy'       => [
        'inputs'    => [
            'trippicker'     => [
                'departure_station' => 'Gare de départ',
                'arrival_satation'  => 'Gare d\'arrivée',
            ],
            'datetimepicker' => [
                'trip_date' => 'Date du voyage',
                'trip_time' => '(Optionnel) À partir de'
            ]
        ],
        'title'     => 'Acheter un billet',
        'catchline' => 'Quel est votre trajet?',
        'research'  => 'Rechercher'

    ]


];
