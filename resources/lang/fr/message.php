<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Message Language Lines
    |--------------------------------------------------------------------------
    */

    'awaiting_offers' => [
        'title'                  => 'Offres en attente',
        'confirm_denial_message' => 'Cette offre a bien été refusé.',
        'confirm_accept'         => 'Offre acceptée ! Commencer la discussion dès maintenant.',
        'accept'                 => 'Discuter',
        'deny'                   => 'Refuser',

        'table' => [
            'ticket'  => 'Billet',
            'buyer'   => 'Acheteur',
            'price'   => 'Prix',
            'actions' => 'Actions'
        ],

        'deny_modal' => [
            'title'                => 'Refuser une offre',
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
                'text'                => 'Êtes vous certain de vouloir refuser cette offre? Si oui merci de nous indiquer pourquoi ci dessous.',
                'low_price_button'    => 'Le prix est trop bas',
                'already_sold_button' => 'J\'ai déjà vendu ce billet',
                'not_for_sale_button' => 'Je ne souhaite plus vendre ce billet'
            ],
            'cancel_button'        => 'Oups, je ne veux pas refuser l\'offre'
        ]
    ],


    'empty' => 'Vous n\'avez pas encore de messages!',


    'discussions' => [
        'title'                => 'Discussions',
        'send'                 => 'Envoyer',
        'sold_to_so_else'      => 'Le billet a été vendu à une autre personne!',
        'sold_disc_ended'      => 'Le billet a été vendu à une autre personne. La discussion est terminée.',
        'bought_from'          => 'Vous avez acheté ce billet à',
        'sold_to'              => 'Vous avez vendu ce billet à',
        'cta_sell_to'          => 'Billet vendu à',
        'cancel'               => 'Annuler',
        'sortByTicketDate'     => 'Trier par date de billet',
        'sortByDiscussionDate' => 'Trier par date de discussion',
        'showBuying'           => 'Montrer les discussions d\'achat',
        'showSelling'          => 'Montrer les discussions de vente',
        'showPast'             => 'Montrer les discussions passées',
        'noDiscussions'        => 'Pas de discussion à afficher',
        'noPastDiscussions'    => 'Pas de discussion passées à afficher',
        'call_seller' => 'Appeler le vendeur',

        'table' => [
            'ticket'       => 'Billet',
            'buyer'        => 'Nom',
            'last_message' => 'Dernier Message',
        ],

        'modal_call' => [
            'title' => 'Appeler le vendeur',
            'explanation' => 'Le vendeur ne vous répond plus? Vous avez un soucis? Le moyen le plus rapide de contacter le vendeur est de l\'appeler directement !'
        ],

        'modal_title'             => 'Comment ça marche ?',
        'modal_explanation_buyer' => 'Le but de cette conversation est, pour vous et l\'acheteur, de trouver le moyen de paiement et le type de remise qui vous conviendront le mieux. 
            Dès que vous aurez reçu le paiement de l\'acheteur, vous devrez lui transmettre votre billet en utilisant le type de remise convenu. 
            Une fois la transaction effectuée, merci de cliquer sur ‘Transaction terminée’. Le billet sera alors retiré de la vente, et vos autres offres seront closes.',

        'modal_explanation_seller' => 'Le but de cette conversation est, pour vous et le vendeur, de trouver le moyen de paiement et le type de remise qui vous conviendront le mieux. 
            Dès que le vendeur aura reçu votre paiement, il vous transmettra son billet en utilisant le type de remise convenu.  Une fois la transaction effectuée, le vendeur cliquera sur un bouton ‘Transaction terminée’, et le billet sera retiré de la vente.',

        'modal_open_faq'        => 'Une question? Un doute? Cliquez-ici pour plus d\'information !',
        'modal_close_understand' => 'Compris !',

        'disclaimer'          => 'Passe Ton Billet n\'est pas un intermédiaire, mais permet uniquement de mettre en contact des vendeurs & acheteurs de billets. Passe Ton Billet décline toute responsabilité dans la transaction de vente.',
        'disclaimer_eurostar' => 'Des contrôles peuvent parfois être effectués en gare pour les billets Eurostar. Si le nom sur le billet ne correspond pas à celui qui figure sur le passeport, l\'accès au train peut-être refusé.',

        'modal_sell' => [
            'title' => 'Vendre ce billet à ',

            'money_received' => [
                'question' => 'Avez-vous reçu le paiement de l\'acheteur?',
                'warning' => 'Ne vous contentez pas d\'une capture d’écran de confirmation ou d\'un email paypal.',
                'confirm' => 'J\'ai reçu l\'argent',
            ],

            'pdf' => [
                'found' => 'Nous avons récupéré le PDF de votre billet et <b>nous l\'enverrons à l\'acheteur dès que vous nous confirmerez la vente</b>, en cliquant sur le bouton ci-dessous.',
                'missing' => 'Nous n\'avons pas pu trouver le PDF de votre billet. <b class="text-bold">Pas de soucis, vous devez simplement vous assurez de bien envoyer le PDF à l\'acheteur</b>.',
                'warning' => 'Cliquez-sur le bouton ci-dessous pour confirmer la vente. Le billet sera alors retiré de la vente, et vos autres conversations seront fermées.',
            ],

            'part_1'    => 'Vous vous apprêtez à marquer ce billet comme vendu à',
            'part_2'    => 'Ne valider qu\'une fois le paiement reçu et le billet envoyé',
            'important' => [
                'title' => 'IMPORTANT',
                'text'  => 'Merci de bien vérifier que vous avez bien reçu le paiement de l’acheteur sur votre compte correspondant et de ne pas vous contenter d’une capture d’écran de confirmation ou d’un email Paypal envoyé par l’acheteur.'
            ]
        ]
    ],

    'success' => [
        'sold' => 'Votre ticket a été vendu! Merci de votre confiance.'
    ],

    'errors' => [
        'not_found'               => 'Discussion introuvable.',
        'ticket_not_found'        => 'Ticket introuvable',
        'cant_accept'             => 'L\'offre ne peut être acceptée',
        'not_active'              => 'Cette conversation est inactive',
        'wrong_user'              => 'Cette conversation n\'est pas la votre!',
        'wrong_ticket_discussion' => 'La combinaison ticket-discussion a échoué.',
        'something'               => 'Quelque chose n\'a pas fonctionné.',
        'already_sold'            => 'Ce ticket est déjà en vente.'
    ],

    'discussion_page' => [
        'modals' => [
            'sell' => [
                'first_part'  => 'Vous êtes sur le point de marqué ce ticket comme vendu.',
                'secund_part' => 'Veuillez vous assurer de ne cliquer ici uniquement après avoir reçu le paiement de l\'acheteur.',
                'third_part'  => 'va automatiquement recevoir votre billet.',
            ]
        ]
    ]


];

