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
        'cta_sell_to'     => 'Vendre ce billet à',
        'cancel'          => 'Annuler',

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

