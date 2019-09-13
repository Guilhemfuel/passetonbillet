<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Nav Language Lines
    |--------------------------------------------------------------------------
    */

    'component' => [
        'buy'                       => 'Acheter',
        'contact'                   => 'Contacter',
        'details'                   => 'Détails',
        'call'                      => 'Appeler',
        'sell'                      => 'Vendre ce billet',
        'sold_by'                   => 'Publié il y a {{days}} par',
        'sold_ago'                  => 'Publié il y a <b>{{days}}</b>',
        'sold_by_sm'                => 'Publié par',
        'edit'                      => 'Modifier',
        'edit_ticket'               => 'Modifier le billet',
        'buy_ticket'                => 'Acheter le billet',
        'your_offer'                => 'Votre offre',
        'seller_ticket_sold'        => 'Billet(s)<br>vendu(s)',
        'seller_ticket_sold_mobile' => 'Billet(s) vendu(s)',
        'member_since'              => 'Membre<br>depuis',
        'member_since_mobile'       => 'Membre depuis',
        'price'                     => 'Prix',
        'send_offer'                => 'Envoyer l\'offre',
        'if_interested'             => 'Le vendeur vous contactera s\'il est interessé.',
        'infos'                     => 'Infos',
        'booking_code'              => 'Numéro de réservation',
        'booking_name'              => 'Nom de réservation',
        'delete'                    => 'Vous ne voulez plus vendre ce billet?',
        'share'                     => 'Lien de partage du billet',
        'share_btn'                 => 'Partager',
        'copied'                    => 'Lien copié dans le presse-papier.',
        'edit_price_cta'            => 'Modifier le prix',
        'delete_cta'                => 'Supprimer le billet',
        'offer_sent'                => 'Le vendeur a bien reçu votre offre! Il vous recontactera si il est interessé.',
        'register'                  => 'La sécurité d\'abord !',
        'register_cta'              => 'Cliquez-ici pour vous inscrire et envoyer une offre !',
        'user_verified'             => 'Nous avons vérifié l\'identité de cet utilisateur.',
        'user_verification_pending' => 'Vérification de l\'identité de l\'utilisateur en cours.',
        'user_not_verified'         => 'Nous n\'avons pas encore vérifié l\'identité de cet utilisateur.',
        'discuss'                   => 'Discuster',
        'new_offer'                 => 'Nouvelle Offre',
        'download_ticket'           => 'Télécharger le billet',
        'download'                  => 'Télécharger',
        'eurostar_ticket_number'    => 'Numéro du billet',
        'security_infos'            => 'Informations de sécurité',

        'status' => [
            'awaiting' => 'En Attente',
            'accepted' => 'Discuter',
            'refused'  => 'Refusée'
        ],

        'security' => [
            'identity'      => [
                'verified'     => 'Identité vérifiée',
                'pending'      => 'Identité en vérification',
                'not_verified' => 'Identité non vérifiée'
            ],
            'tickets_sold'  => 'Billet(s) vendu(s)',
            'register_date' => 'Date d\'adhésion'
        ],

        'buying_actions' => [
            'offer' => [
                'btn'          => 'Envoyer une offre',
                'back_to_call' => 'Appeler le vendeur directement'
            ],
            'call'  => [
                'btn'     => 'Appeler Vendeur',
                'refresh' => 'Rafraichir le numéro',
                'pricing' => '3€/appel + prix appel',
            ]
        ],

        'help_modal' => [
            'title' => 'Quelle option choisir ?',
            'offer' => [
                'title'   => 'Prenez votre temps, il y a pleins d\'autres billets !',
                'content' => 'Le vendeur recevra votre offre par email et il pourra l\'accepter ou la refuser. Vous ne pourrez parler au vendeur via notre chat que si votre offre est acceptée.'
            ],
            'call'  => [
                'title'   => 'Ne ratez pas votre billet idéal !',
                'content' => 'Vous pouvez maintenant appeler directement le vendeur et négocier le billet. C’est beaucoup plus efficace !'
            ]
        ],

        'share_modal' => [
            'title'        => 'Vendez votre billet plus rapidement en le publiant sur Facebook!',
            'step_1'       => '1. Partagez le avec vos amis sur votre compte Facebook',
            'step_2'       => '2. Parlez en sur notre groupe Facebook',
            'share_on_fb'  => 'Partager sur facebook',
            'text_link'    => 'Votre lien de partage direct',
            'copy_link'    => 'Copier le lien',
            'our_fb_group' => 'Publiez votre lien direct de billet sur notre groupe :'
        ],

        'delete_modal' => [
            'already_sold'         => [
                'text_offers'     => 'Vous avez déjà vendu votre billet? Génial! Merci de nous indiquer ci-dessous qui est l\'acheteur afin que l\'on puisse marquer votre billet comme vendu.
                    Si vous cliquer sur "J\'ai vendu le billet ailleurs", le billet sera complétement supprimé du site.',
                'text_no_offers'  => 'Vous n\'avez pas encore accepter d\'offres sur PasseTonBillet. Cliquez sur "J\'ai vendu le billet ailleurs" pour complétement supprimer le billet de PasseTonBillet.',
                'sold_to'         => 'Vendu à',
                'sold_else_where' => 'J\'ai vendu le billet ailleurs',
            ],
            'sold_else_where'      => [
                'text'               => 'Si vous avez vendu ce billet sur PasseTonBillet, <b>NE CLIQUEZ PAS</b> sur le bouton de confirmation ci-dessous mais faîtes nous plutot savoir à qui vous l\'avez vendu.
                Cela vous nous aide à gérer le statut des transactions en cours, mais surtout celà vous permet d\'avoir une meilleure réputation sur PasseTonBillet!
                En effet, le nombre de billet vendu avec succès sur votre profil augmentera 👍',
                'sold_on_ptb_button' => 'Oups, j\'ai vendu le billet à quelqu\'un sur le site',
                'sold_else_where'    => 'Je confirme que j\'ai vendu le billet ailleurs',
            ],
            'not_for_sale_anymore' => [
                'text'               => 'Si vous avez vendu ce billet sur PasseTonBillet, <b>NE CLIQUEZ PAS</b> sur le bouton ci-dessous mais faîtes nous plutot savoir à qui vous l\'avez vendu.
                Cela vous nous aide à gérer le statut des transactions en cours, mais surtout celà vous permet d\'avoir <b>une meilleure réputation</b> sur PasseTonBillet!
                En effet, le nombre de billet vendu avec succès sur votre profil augmentera 👍',
                'sold_on_ptb_button' => 'Oups, j\'ai vendu le billet à quelqu\'un sur le site',
                'confirm_button'     => 'Je ne veux plus vendre ce billet'
            ],
            'find_reason'          => [
                'text'                => 'Êtes vous certain de vouloir supprimer ce billet? Si oui merci de nous indiquer pourquoi ci dessous.',
                'already_sold_button' => 'J\'ai déjà vendu ce billet',
                'not_for_sale_button' => 'Je ne souhaite plus vendre ce billet'
            ],
            'cancel_button'        => 'Oups, je ne veux pas le supprimer'
        ],

        'call_seller_modal' => [
            'title'      => 'Appeler le vendeur',
            'text'       => 'Vous pouvez maintenant appeler directement le vendeur et négocier le billet. C’est beaucoup plus efficace ! Cliquez sur le bouton correspondant au pays de votre opérateur téléphonique pour obtenir un numéro de contact.',
            'btn_cta'    => 'Obtenir un numéro',
            'refresh'    => 'Rafraichir le numéro',
            'pricing_fr' => '3€/appel + prix appel',
            'pricing_uk' => '2.5£/appel + prix appel',
        ],

        'edit_price_modal' => [
            'title'  => 'Modifier le prix du billet',
            'text'   => 'Vous pouvez modifier le prix de votre billet à tout instant.',
            'submit' => 'Modifier prix'
        ],

        'type' => [
            'second_hand' => "billet de train<br/> d'occasion",
            'new'         => "billet de train<br/> neuf",

        ]

    ],
    'sell'      => [

        'public' => [

            'title'            => 'Revendre un billet de train SNCF, OuiGo, Eurostar, Thalys avec PasseTonBillet.fr',
            'meta_description' => 'Vous avez un billet de train à revendre (Billet SNCF, Prems, e-billet, Eurostar, Thalys...). Sur PasseTonBillet.fr, il sera vendu dans la journée ! c\'est gratuit et très rapide.',
            'subtitle'         => 'Billets SNCF, Billets Eurostar, Billets Prems, Billets Thalys, Billets OuiGo',
            'favorites'        => [
                'title'    => 'Revendez votre billet en 1 clic',
                'subtitle' => 'Revendre un billet London, Paris, Lyon, Marseille, ou autre sur PasseTonBillet.fr .'
            ],

            'reviews'     => 'Les avis de nos utilisateurs',
            'recent'      => 'Les Derniers billets postés',
            'question'    => 'Vous avez un billet de train non échangeable / non remboursable a revendre ?',
            'subquestion' => ' PasseTonBillet est spécialisé dans la revente de billets de train d\'occastion. Les voyageurs peuvent facilement:',
            'video_title' => 'Vendre des billets sur PasseTonBillet'
        ],


        'title' => 'Vendre un billet',

        'step_1'            => 'Étape 1/2: Retrouver votre billet',
        'description'       => 'Vendre un billet est très simple et très rapide. Tout ce que vous avez à faire est d\'entrer votre nom de famille ainsi que votre numéro de réservation. Tous les tickets correspondants à cette reservation vont alors aparaître et vous n\'aurez plus qu\'à séléctionner ceux que vous souhaitez mettre en vente.',
        'inputs'            => [
            'first_name'   => 'Prénom de famille associé à la reservation',
            'last_name'    => 'Nom de famille associé à la reservation',
            'email'        => 'Addresse email utilisée pour la reservation',
            'booking_code' => 'Référence de réservation',
            'price'        => 'Prix de vente',
            'notes'        => 'Vous pouvez écrire ici une description pour ce billet...'
        ],
        'search'            => 'Chercher le(s) billet(s)',
        'other_name'        => 'Contactez-nous pour vendre un billet associé à un autre nom.',
        'help_booking_code' => 'Cette référence se trouve sur votre confirmation de reservation / commande ou sur votre billet après "Dossier" ou "PNR" et est composé de 6 caractères.',
        'searching'         => 'Recherche de vos billets...',
        'select'            => 'Hooray ! Nous avons trouvé vos billets. Selectionnez le billet que vous souhaitez vendre.',
        'step_2'            => 'Étape 2/2: Compléter les informations sur la vente',
        'details'           => 'Nous avons presque terminé! Il ne vous reste qu\'à indiquer votre prix. Vous pouvez prévisualiser vos changement directement sur le billet.',
        'submit'            => 'Vendre le billet',
        'preview'           => 'Prévisualisation du billet',
        'errors'            => [
            'min_value'       => 'Whoops ! Le prix de revente ne peut être inférieur à 1 ! Essayez encore avec un prix plus haut.',
            'manual_eurostar' => 'Whoops! Vous ne pouvez pas utiliser le formulaire de vente manuel pour vendre un billet eurostar.',
            'duplicate'       => 'Whoops ! Ce billet a déjà été mis en vente...',
            'search'          => 'Whoops ! Aucun billet trouvé... Essayez à nouveau, et si le problème persiste, contactez-nous.'
        ],
        'success'           => 'Hooray! Votre billet est maintenant disponible à l\'achat ! Merci de votre confiance !',

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
            'link'           => 'Vous n\'avez pas de numéro de réservation? Cliquer ici pour rentrer les informations de votre billet manuellement.',
            'title'          => 'Ajout Manuel de Billet',
            'fail_retrieval' => [
                'title'                => 'Aucun résultat trouvé pour votre combinaison nom/réservation.',
                'message'              => 'Malheuresment, nous n\'avons trouvé aucun billet.',
                'message_extra_fields' => 'Aucun billet n\'a été trouvé. Merci de préciser l\'email utilisé pour la réservation, et d\'essayer à nouveau.'
            ],
            'text'           => "Si vous souhaitez vendre un billet cartonné, ou que nous n'avons pas pu retrouver votre billet, il vous suffit de remplir ce formulaire.",
            'back_link'      => 'Vous avez votre numéro de réservation? Cliquez ici pour retrouver votre billet automatiquement.',

            'eurostar_back_to_automatic' => 'Merci de passer par le formulaire de vente automatique pour vendre un billet eurostar.',

            'form' => [
                'title_travel'      => 'Informations sur le voyage',
                'departure_station' => 'Gare de départ',
                'arrival_station'   => 'Gare d\'arrivée',
                'travel_date'       => 'Date de voyage',
                'train_number'      => 'Numéro de train',
                'departure_time'    => "Heure de Départ",
                'arrival_time'      => "Heure d'Arrivée",
                'title_ticket'      => 'Informations sur le billet',
                'company'           => 'Agence ferroviaire',
                'flexibility'       => 'Tarif',
                'classe'            => 'Classe',
                'currency'          => 'Devise',
                'bought_price'      => 'Prix d\'achat',
                'price'             => 'Prix de vente',
                'cgu'               => 'Je reconnais avoir pris connaissance des <a href="' . route( 'cgu.page' ) . '" target="blank" >conditions d\'utilisation</a> et je les accepte sans réserves.'
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
            'homepicker'     => [
                'depart'  => 'Départ',
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
        'title'                  => 'Mes Billets',
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
    'alerts'    => [


        'page' => [
            'title'          => 'Mes Alertes',
            'btn_create_new' => 'Clickez ici pour créer une nouvelle Alerte'
        ],

        'create_alert'   => 'Créer une alerte',
        'catchline_text' => 'Marre de passer à côté du billet idéal ?',
        'action_text'    => 'Créez une alerte et soyez le premier averti !',

        'modal'          => [
            'title'       => 'Créer une alerte',
            'form'        => [
                'departure_station'    => 'Gare de départ',
                'arrival_station'      => 'Gare d\'arrivée',
                'departure_date_start' => 'Date de début d\'alerte',
                'departure_date_end'   => 'Date de fin d\'alerte',
            ],
            'explanation' => 'Créez une alerte maintenant, et recevez une notification par email lorsqu\'un utilisateur publie un billet qui correspond à vos critères de recherche.',

            'submit' => 'Créer l\'alerte'
        ],
        'success'        => 'Alerte créée !',
        'success_delete' => 'Alerte supprimée.',

        'duplicate_alert' => 'Vous avez déjà cette alerte d\'enregistrée.',
        'past_alert'      => 'Vous ne pouvez pas créer une alerte dans le passé.',
        'date_order' => 'La date début doit etre égale ou avant la date de fin.',
        'alert_not_found' => 'Alerte introuvable.',
        'existing_user'   => 'Vous avez déjà un compte PasseTonBillet. Merci de vous connecter pour créer l\'alerte.',


    ],

    'updated' => 'Billet mis à jour avec succès.',

    'delete' => [
        'success' => 'Votre ticket a bien été supprimé.'
    ],
    'errors' => [
        'passed' => 'Ce ticket est déjà passé! Cherchews'
    ]


];
