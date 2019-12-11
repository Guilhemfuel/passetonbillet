<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Nav Language Lines
    |--------------------------------------------------------------------------
    */

    'component' => [
        'yes'                       => 'Oui',
        'no'                        => 'Non',
        'validate'                  => 'Valider',
        'submit'                    => 'Soumettre',
        'finish'                    => 'Terminer',
        'resolve'                   => 'Résoudre',
        'buy'                       => 'Acheter',
        'update'                    => 'Modifier',
        'update_price'              => 'Modifier prix',
        'delete_button'             => 'Supprimer',
        'help_button'               => 'Aide',
        'change_pdf'                => 'Changer PDF',
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

        'step_1'            => 'Étape 1/4: Retrouver votre billet',
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
        'step_2'            => 'Étape 2/4: Compléter les informations sur la vente',
        'step_3'            => 'Étape 3/4: Ajoutez vos billets',
        'step_4'            => 'Étape 4/4: Mettez votre billet en vente',
        'details'           => 'Nous avons presque terminé! Il ne vous reste qu\'à indiquer votre prix. Vous pouvez prévisualiser vos changement directement sur le billet.',
        'submit'            => 'Vendre le billet',
        'preview'           => 'Prévisualisation du billet',
        'errors'            => [
            'min_value'       => 'Whoops ! Le prix de revente ne peut être inférieur à 1 ! Essayez encore avec un prix plus haut.',
            'manual_eurostar' => 'Whoops! Vous ne pouvez pas utiliser le formulaire de vente manuel pour vendre un billet eurostar.',
            'duplicate'       => 'Whoops ! Ce billet a déjà été mis en vente, contactez-nous pour le remttre en vente.',
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
        ],

        'eurostar_warning_fb_group' => [
            'title'   => '<span class="text-danger"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i><br>
            Avertissement: ne pas poster votre billet Eurostar® sur des groupes Facebook !</span>',
            'message' => 'Eurostar® vérifie désormais tous les billets postés sur TOUS les groupes Facebook. 
            S\'ils parviennent à lier votre publication Facebook à votre réservation Eurostar® via votre nom Facebook et
             le contenu de votre publication, votre billet pourra être annulé, sans aucun remboursement possible.<br><br>
             PasseTonBillet ne peut être tenu respondable en cas d\'annulation de votre billet.',
            'button'  => "J'ai bien compris et je posterai pas mon billet sur Facebook"
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
            'btn_create_new' => 'Cliquez ici pour créer une nouvelle Alerte'
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
        'passed' => 'Ce ticket est déjà passé!'
    ],

    'pdf' => [
        'description_1' => 'Si ton fichier PDF contient plusieurs billets, assurez vous de télécharger touts les billets.
        À l\'étape suivante vous pourrez ensuite choisir quels billets vous souhaitez mettre en vente.',

        'description_2' => 'Personne ne pourra voir vos billets avant qu\'ils aient été payés.',

        'description_3' => 'Vous pouvez télécharger des fichiers PDF ou Pkpass (Apple Wallet).',

        'select_file' => 'Séléctionner un fichier',

        'price_too_high' => 'Le prix est trop haut et ne peut pas dépasser :',

        'zoom_pdf' => 'Agrandir',

        'verif_pdf_error' => 'Erreur lors de la vérification PDF',

        'choose_pdf' => 'Choisisez le PDF qui correpond au billet que vous souhaitez vendre',
        'choose_this_ticket' => 'Choisir ce billet',
        'sell_this_ticket' => 'Ceci est le billet en vente',
    ],

    'step_4' => [
        'text_1' => 'Merci de confirmer que vous ne revendez pas votre billet sur une autre plateforme que Passetonbillet. Cela nous permet de garantir aux acheteurs potentiels que votre billet est disponible et qu’ils peuvent le télécharger directement après avoir effectué le paiement. ',
        'text_2' => 'Autre plateformes: Kelbillet, Trocsdestrains, Zepass, Facebook',
        'text_3' => 'Vous recevrez un lien unique par billet que vous pourrez partager sur Facebook qui permettra aux personnes interessées d’acheter le billet directement depuis PasseTonBillet.',
        'text_4' => 'Je garantie que mon billet est uniquement en vente sur Passetonbillet.'
    ],

    'buy_modal' => [
        'buy_ticket_of' => 'Acheter le ticket de',
        'instant_receive' => 'Vous recevrez le billet instantanément',
        'choose_payment' => 'Choisissez un moyen de paiement',
        'add_payment' => 'Ajoutez un moyen de paiement',
        'add' => 'Ajouter',
        'error' => 'Une erreur est survenue',

        'send_email_to' => 'Nous avons envoyé votre billet à',
        'have_good_trip' => 'Bon voyage !',

        'ticket_doesnt_exist' => 'Ce ticket n\'existe pas !',
        'no_mangopay' => 'Un problème est survenu avec mangopay',
        'ticket_already_sold' => 'Ce ticket a déjà été vendu !',
    ],

    'api' => [
        'not_allowed'            => 'Vous n\'êtes pas autorisé à modifier ce ticket',
        'price_empty'            => 'Le prix n\'est pas renseigné',
        'pdf_empty'              => 'Aucun PDF !',
        'pdf_uploaded'           => 'PDF téléchargé avec succès !',
        'price_updated'          => 'Prix modifié !',
        'ticket_deleted'         => 'Billet supprimé avec succès !',
        'delete_ticket_no_right' => 'Vous n\'avez pas le droit de supprimer ce billet',
        'confirm_delete'         => 'Êtes-vous sûr de vouloir supprimer ce billet ?',
    ],

    'claim' => [
        'start' => 'Avez-vous eu rencontré un problème avec ce billet ?',
        'start_more' => 'Si vous n’avez pas pu voyager avec ce billet, vous avez 48 heures pour nous le signaler en ouvrant un conflit avec le vendeur',
        'i_have_question' => 'Non, j\'ai une question',

        'we_answers' => 'Nous répondons à vos questions',
        'read_our_faq' => 'Nous vous invitons à lire nos FAQs qui contiennent les réponses à toutes les questions fréquentes que les acheteurs peuvent se poser',
        'read_faq' => 'LIRE LES FAQs',
        'common_questions' => 'Questions Fréquentes',
        'charge_included' => 'Frais de gestion inclus',

        'question_1' => 'Avez-vous essayé de scanner le billet en personne?',
        'question_1_more' => 'Êtes-vous la personne qui a essayé de scanner le billet aux bornes automatiques?',

        'question_2' => 'À quelle heure avez-vous essayé de scanner le billet?',
        'question_2_more' => 'C’est important d’être le plus précis possible. Nous pouvons vérifier dans notre système',

        'question_3' => 'Avez-vous rencontré un problème au moment du scannage du billet ?',
        'question_3_more' => 'Cela se traduit généralement par un message d’erreur sur les bornes automatiques vous demandant de contacter un agent',

        'question_4' => 'Avez-vous été controlé après avoir scanné le billet?',
        'question_4_more' => 'Lors d’un controle, l’agent de sécurité peut demander de vérifier que le nom du billet correspond au nom sur votre pièce d’identité',

        'question_5' => 'Merci d’ajouter ici toute information supplémentaire qui pourrait être utile dans la résolution de ce conflt:',
        'more_info' => 'Informations supplémentaires...',

        'end' => 'Conflit créé',
        'end_more' => 'Merci! Nous avons pris en compte vos réponses et nous vous contacterons d’ici peu avec le verdict final.',

        'hours_left' => 'Hours left',
        'claim_limit_reached' => 'Les 48 heures pendant lesquelles vous pouviez signaler un problème sont passées. Le vendeur a reçu votre paiement.',

        'api' => [
            'no_data' => 'Pas de données envoyés',
            'claim_sent' => 'Litige envoyé !',
            'claim_date_limit' => 'Demande de litige impossible, les 48h sont passés',
            'claim_before_departure' => 'Vous ne pouvez pas faire une demande de litige avant le départ',
            'claim_not_possible' => 'Vous ne pouvez pas créer un litige si aucun litige n\'a été crée de la part de l\'acheteur'
        ],

        'succeeded' => 'Paiement effectué',
        'created' => 'Paiement en cours',
        'no_bank_account' => 'Veuillez fournir un compte bancaire',
        'no_kyc' => 'Veuillez fournir une pièce d\'identité',
        'failed' => 'Une erreur est survenue pour la validation de votre paiement',
        'won' => 'Paiement reversé à l\'acheteur suite au litige',
        'lost' => 'Le litige est en votre faveur',
        'equality' => 'Vous ne recevrez que la moitié du paiement',
    ],

    'claim_seller' => [
        'start' => 'Résoudre le conflit',
        'start_more' => 'L’acheteur n’a pas pu voyager avec votre billet pour la raison suivante:',
        'unvalid_ticket' => 'Billet non valide',
        'you_have_limited_time' => 'Vous avez :hours heures pour résoudre ce conflit ou l’acheteur sera remboursé',

        'question_1' => 'À part sur Passetonbillet.fr et les groupes Facebook appartenant au site, avez-vous mis votre billet en vente sur d’autres plateformes? ',
        'question_1_more' => '(ex: Trocsdestrains.fr, Kelbillet.fr, Zepass.com, autres groupes Facebook…)',

        'question_2' => 'Avez-vous bien téléchargé le billet complet original lors de la mise en vente sur Passetonbillet.fr?',
        'question_2_more' => 'Le billet doit être téléchargé directement depuis le site Eurostar, Thalys, SNCF ou autre.',
    ],

    'update_bank_account' => 'Ajouter mon IBAN',
    'bank_account_not_complete' => 'Veuillez compléter le formulaire entièrement',
    'bank_account_not_valid' => 'Il semblerait que les informations sont invalide',
    'bank_account_success' => 'Votre compte bancaire est ajouté !',

    'no_ticket' => 'Pas de billet pour l\'instant',

    'mangopay_error' => 'Une erreur est survenue avec notre service de paiement',
];
