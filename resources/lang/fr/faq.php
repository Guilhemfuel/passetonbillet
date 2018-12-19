<?php

return [

    /*
    |--------------------------------------------------------------------------
    | FAQ Language Lines
    |--------------------------------------------------------------------------
    */


    'title'   => 'Aide',
    'no_result' => 'Aucun résultat ne correspond à votre recherche.',
    'no_answer' => 'Vous n\'avez pas trouvé une réponse à votre question ? Clickez ici pour nous contacter !',
    'search_placeholder' => 'Que cherchez-vous ?',

    'questions' => [
        [
            'title' => 'Comment acheter un billet ?',
            'content'=>'Pour acheter un billet, vous devez d’abord créer un compte, puis choisir le billet qui vous intéresse, soit en utilisant le moteur de recherche de la plateforme, soit en cliquant sur un lien direct de billet.<br> 
            Une fois que vous avez trouvé un billet qui vous intéresse, vous devez faire une offre inférieure ou égale au prix de revente du billet. Le vendeur du billet va alors être automatiquement notifié, et pourra accepter ou refuser votre offre:
            <ul><li>S’il accepte votre offre, vous serez alors notifié par email et une conversation avec le vendeur sera alors automatiquement créée dans ‘Offres’ dans laquelle vous pourrez vous mettre d’accord sur le moyen de paiement et le type de remise qui vous convient le mieux à tous les deux. Une fois que le billet a été envoyé, vous devez impérativement demander au vendeur de cliquer sur ‘Transaction terminée’ pour retirer le billet de la vente et signaler qu’il vous a bien été vendu.</li><li>S’il refuse votre offre, vous pourrez alors faire une contre-offre à un prix supérieur à celui proposé lors de la première offre ou tout simplement choisir un autre billet. 
            </li></ul>',
            'tags' => ['acheter','buy','ticket','buy ticket','acheter un billet', 'offre']
        ],
        [
            'title' => 'Est-il possible de contacter un vendeur directement ?',
            'content'=> 'Non, pour des raisons de sécurité, il n’est pas possible de contacter un vendeur directement. Le seul moyen de contacter un vendeur de la plateforme est dans les conversations créées dans ‘Offres’ une fois que le vendeur a accepté votre offre. Nous ne communiquerons en aucun cas les numéros de téléphone des vendeurs.',
            'tags' => ['contacter','contact','seller','vendeur','contact directly', 'contacter directment']
        ],
//        [
//            'title' => 'Comment créer une alerte pour un billet ?',
//            'content'=> 'Pour créer une alerte pour un billet, il vous suffit d’effectuer une recherche pour le trajet de votre choix, puis de cliquer sur ‘Créer une alerte’ en haut des résultats de la recherche. Entrez votre adresse email ainsi que les critères de votre recherche, et l’alerte sera automatiquement créée. Vous serez alors immédiatement notifié par email lorsqu’un vendeur mettre en vente un billet qui correspond à ce que vous recherchez. Si vous avez déjà un compte, vous pouvez retrouver vos alertes et les modifier ou en créer de nouvelles en allant dans ‘Mes Alertes’.'
//        ],
        [
            'title' => 'Je me suis connecté avec Facebook, mon nom de famille est incorrect. Comment puis-je le changer ?',
            'content'=> 'Pas d’inquiétude, si vous avez déjà soumis une copie d’une pièce d’identité pour vérification votre nom, prénom et date de naissance seront automatiquement mis à jour avec vos informations officielles. Si ce n’est toujours pas le cas après vérification de votre profil, merci de nous contacter directement. Si vous n’avez pas encore soumis une copie d’une pièce d’identité pour vérification de votre compte, nous invitons à le faire en allant dans ‘Mon Profil’ > ‘Vérifier mon compte’.',
            'tags' => ['facebook connect','connexion avec facebook','nom','surname','change surname', 'family name','change family name','nom de famille','changer nom de famille']
        ],
        [
            'title' => 'Comment puis-je voir combien de billets un vendeur a vendu avec succès ?',
            'content'=> 'Il vous suffit de cliquer sur son nom dans la partie inférieur (blanche) d’un billet. Vous aurez alors accès à toutes les informations disponibles sur le vendeur. ',
            'tags' => ['seller','vendeur','combien de billets vendu','how many ticket sold','trust seller', 'fiabilité vendeur']
        ],
        [
            'title' => 'Quels sont les moyens de paiement conseillés pour les transactions ?',
            'content'=> 'Par soucis de sécurité et de rapidité nous conseillons d’utiliser Paypal, Revolut ou Lydia pour toutes les transactions. Les virements bancaires entre comptes ANGLAIS sont également conseillés. Les virement bancaires à partir d’un/vers un compte Français prennent plusieurs jours à arriver et sont donc déconseillés. ',
            'tags' => ['payment','paiement','moyen de paiement','bank','banque', 'argent','money']
        ],
    ]

];
