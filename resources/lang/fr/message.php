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
        'accept'                 => 'Accepter',
        'deny'                   => 'Refuser'
    ],


    'empty' => 'Vous n\'avez pas encore de messages!',


    'discussions' => [
        'title'           => 'Discussions',
        'send'            => 'Envoyer',
        'sold_to_so_else' => 'Le billet a été vendu à une autre personne!',
        'sold_disc_ended' => 'Le billet a été vendu à une autre personne. La discussion est terminée.',
        'bought_from'     => 'Vous avez acheté ce billet à',
        'sold_to'         => 'Vous avez vendu ce billet à',
        'cta_sell_to'     => 'Envoyer ce billet à',
        'cancel'          => 'Annuler',

        'modal_title' => 'Comment ça marche ?',
        'modal_explanation_buyer' => [
            'part_one' => 'Le but de cette conversation est, pour vous et l\'acheteur, de trouver le moyen de paiement qui conviendra le mieux.<br>
                        Dès que vous aurez reçu le paiement de l\'acheteur, vous devrez clicker sur le bouton "Envoyer ce billet à ',
            'part_two' => '". L\'acheteur recevra automatiquement son billet, pas besoin de vous soucier de quoique ce soit d\'autre ! 😄'
        ],
        'modal_explanation_seller' => 'Le but de cette conversation est, pour vous et le vendeur, de trouver le moyen de paiement qui conviendra le mieux.<br>
                        Dès que le vendeur aura reçu votre paiement, elle/il aura juste à appuyer sur un boutton et nous vous enverrons le billet par email! C\'est aussi simple que ça ! 😄',
        'modal_open_chat' => 'Une question? Un doute? Clickez-ici pour discuter avec la team!',
        'modal_close_understand'   => 'Compris !',


        'explanation_buyer'  =>'Rappel: le but de cette conversation est de trouver le moyen de paiement qui conviendra le mieux à vous et au vendeur. Nous vous enverrons le billet dès que le vendeur aura reçu votre paiement.',
        'explanation_seller'  =>'Rappel:  le but de cette conversation est de trouver le moyen de paiement qui conviendra le mieux à vous et à l\'acheteur. Cliquez sur le bouton "Vendre ce billet à X" ci-dessus dès que vous recevrez le paiement de l\'acheteur.',


        'modal_sell' => [
            'part_1' => 'Vous vous apprêtez à envoyer cd billet à',
            'part_2' => 'Ne valider qu\'une fois le paiement reçu.',
            'part_3' => 'recevra automatiquement votre billet',
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
                'third_part'  => 'va automatiquement recevoir votre billet.'
            ]
        ]
    ]


];

