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
        'cta_sell_to'     => 'Transaction terminée',
        'cancel'          => 'Annuler',

        'modal_title'             => 'Comment ça marche ?',
        'modal_explanation_buyer' => 'Le but de cette conversation est, pour vous et l\'acheteur, de trouver le moyen de paiement et le type de remise qui vous conviendront le mieux. 
            Dès que vous aurez reçu le paiement de l\'acheteur, vous devrez lui transmettre votre billet en utilisant le type de remise convenu. 
            Une fois la transaction effectuée, merci de cliquer sur ‘Transaction terminée’. Le billet sera alors retiré de la vente, et vos autres offres seront closes.',

        'modal_explanation_seller' => 'Le but de cette conversation est, pour vous et le vendeur, de trouver le moyen de paiement et le type de remise qui vous conviendront le mieux. 
            Dès que le vendeur aura reçu votre paiement, il vous transmettra son billet en utilisant le type de remise convenu.  Une fois la transaction effectuée, le vendeur cliquera sur un bouton ‘Transaction terminée’, et le billet sera retiré de la vente.',

        'modal_open_chat'          => 'Une question? Un doute? Clickez-ici pour discuter avec la team!',
        'modal_close_understand'   => 'Compris !',

        'disclaimer'  => 'Passe Ton Billet n\'est pas intermédiaire, mais permet uniquement de mettre en contact des vendeurs & acheteurs de billets. Passe Ton Billet décline toute responsabilité dans la transaction de vente.',

        'modal_sell' => [
            'part_1' => 'Vous vous apprêtez à marquer ce billet comme vendu à',
            'part_2' => 'Ne valider qu\'une fois le paiement reçu et le billet envoyé',
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

