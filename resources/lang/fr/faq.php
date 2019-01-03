<?php

return [

    /*
    |--------------------------------------------------------------------------
    | FAQ Language Lines
    |--------------------------------------------------------------------------
    */


    'title'              => 'Aide',
    'no_result'          => 'Aucun résultat ne correspond à votre recherche.',
    'no_answer'          => 'Vous n\'avez pas trouvé une réponse à votre question ? Clicker ici pour nous contacter !',
    'search_placeholder' => 'Que cherchez-vous ?',

    'questions' => [
        [
            'title'   => 'Comment revendre un billet ?',
            'content' => 'Pour revendre un billet, vous devez d’abord créer un compte, puis cliquer sur ‘Revendre un billet’ en haut à droite de l’écran. Entrez simplement la référence de réservation de votre billet et celui-ci va apparaître. Si vous avez plusieurs billets sous la même réservation, vous pouvez choisir celui que vous souhaitez revendre en les différenciant grâce au numéro de billet unique. Une fois que vous avez choisi le billet que vous souhaitez revendre, vous n’avez plus qu’à entrer le prix auquel vous souhaitez le revendre et cliquer sur “Revendre”. Une fois votre billet en vente, il est visible par tous les autres utilisateurs de PasseTonBillet.fr. Ceux-ci peuvent vous faire des offres inférieures ou égales au prix de revente. Lorsque vous recevrez une offre d’un acheteur potentiel, vous serez alors immédiatement notifié via email. Vous pourrez alors alors accepter ou refuser l’offre en allant dans ‘Offres’. 

            <ul><li>Si vous acceptez une offre, une conversation avec le potentiel acheteur sera alors automatiquement créée dans laquelle vous pourrez vous mettre d’accord sur le moyen de paiement qui vous convient le mieux à tous les deux. Une fois que vosu avez reçu le paiement de l’acheteur, vous devez impérativement cliquer sur ‘Transaction terminée’ en haut de la conversation avec l’acheteur à qui vous avez vendu le billet. Cela enverra le PDF du billet unique directement à l’acheteur, et retirera votre billet de la vente. Vous serez également crédité d’une revente avec succès ! 
                </li><li>Si vous refusez une offre, vous devez choisir la raison pour laquelle vous l’avez fait et l’acheteur sera alors averti, il pourra faire une contre-offre si le billet est toujours disponible.</li></ul>
            <br><b>IMPORTANT: Merci de bien vérifier que vous avez bien reçu le paiement de l’acheteur sur votre compte correspondant et de ne pas vous contenter d’une capture d’écran de confirmation ou d’un email Paypal envoyé par l’acheteur.</b>',
            'tags'    => [
                'revendre',
                'vendre',
                'ticket',
                'sell ticket',
                'vendre un billet',
                'comment',
                'offer',
                'have to',
                'dois-je'
            ]
        ],
        [
            'title'   => 'Est-il possible de contacter un acheteur directement ?',
            'content' => 'Non, pour des raisons de sécurité, il n’est pas possible de contacter un acheteur directement. Le seul moyen de contacter un acheteur est dans les conversations créées dans ‘Offres’ une fois que vous avez accepté son offre. Nous ne communiquerons en aucun cas les numéros de téléphone des acheteurs.',
            'tags'    => [
                'contacter',
                'contact',
                'seller',
                'vendeur',
                'contact directly',
                'contacter directment',
                'rapidement',
                'rapide',
                'quicker',
                'quick'
            ]
        ],

        [
            'title'   => 'J’ai plusieurs billets sous la même réservation, comment puis-je choisir lequel je souhaite revendre? ',
            'content' => 'Chaque e-billet généré par Eurostar, SNCF ou Thalys comporte un numéro unique composé de 9 chiffres (‘ticket number’) présent en dessous du code barre. Sur PasseTonBillet.fr, lorsque vous entrez le numéro d’une réservation contenant plusieurs billets, tous les billets sous cette même réservation vont apparaître. Dans le coin en haut à droite de chacun des billets vous pourrez voir son ‘numéro de billet’ (ou ticket number). Ainsi, vous pouvez choisir le billet spécifique que vous souhaitez revendre.',
            'tags'    => [
                'choisir',
                'choose',
                'select',
                'plusieurs',
                'couple',
                'AR',
                'A/R',
                'return',
                'ticket',
                'tickets',
                'billets',
                'billet',
                'different',
                'same',
                'même',
                'reservation',
                'booking'
            ]
        ],
        [
            'title'   => 'Quels sont les moyens de paiement conseillés pour les transactions ?',
            'content' => 'Par soucis de sécurité et de rapidité nous conseillons d’utiliser Paypal, Revolut ou Lydia pour toutes les transactions. Les virements bancaires entre comptes ANGLAIS sont également conseillés. Les virement bancaires à partir d’un/vers un compte Français prennent plusieurs jours à arriver et sont donc déconseillés. ',
            'tags'    => [
                'payment',
                'paiement',
                'moyen de paiement',
                'bank',
                'banque',
                'argent',
                'money',
                'paypal',
                'revolut',
                'monzo',
                'transfer',
                'wire',
                'virement',
                'transaction'
            ]
        ],
        [
            'title'   => 'Comment envoyer mon billet à l’acheteur ?',
            'content' => 'Lorsque vous avez reçu le paiement d’un acheteur pour votre billet, il vous suffit de cliquer sur ‘Transaction Terminée’ en haut de la conversation avec cet acheteur. L’acheteur recevra alors automatiquement votre billet unique, et celui-ci sera alors immédiatement retiré de la vente et toutes les conversations avec d’autres acheteurs intéressés par ce billet seront terminées.
            <br><b>IMPORTANT: Merci de bien vérifier que vous avez bien reçu le paiement de l’acheteur sur votre compte correspondant et de ne pas vous contenter d’une capture d’écran de confirmation ou d’un email Paypal envoyé par l’acheteur.</b>',
            'tags'    => [
                'send',
                'envoyer',
                'billet',
                'ticket',
                'transférer',
                'transfer',
                'mail',
                'email',
                'facebook'
            ]
        ],
        [
            'title'   => 'Comment envoyer mon billet à l’acheteur ?',
            'content' => 'Lorsque vous avez reçu le paiement d’un acheteur pour votre billet, il vous suffit de cliquer sur ‘Transaction Terminée’ en haut de la conversation avec cet acheteur. L’acheteur recevra alors automatiquement votre billet unique, et celui-ci sera alors immédiatement retiré de la vente et toutes les conversations avec d’autres acheteurs intéressés par ce billet seront terminées.',
            'tags'    => [
                'send',
                'envoyer',
                'billet',
                'ticket',
                'transférer',
                'transfer',
                'mail',
                'email',
                'facebook'
            ]
        ],
        [
            'title'   => 'Pourquoi ne puis-je pas revendre mon billet plus cher qu’au prix d’achat initial ?',
            'content' => 'Il est illégal de revendre un billet de train en faisant un profit financier. De plus, le but de PasseTonBillet.fr est de proposer des billets à prix bas pour tous les jours de l’année. <br><b>IMPORTANT: Il est totalement illégal pour un vendeur de demander un prix supérieur pour son billet à celui auquel il a accepté l’offre. Si un vendeur demande de payer un prix supérieur à celui convenu lors de l’offre qu’il a accepté, quelque soit le prétexte (plusieurs offres pour le même billet, des frais supplémentaires dûs à des modifications, etc…), il sera immédiatement définitivement banni.</b>',
            'tags'    => [
                'prix',
                'price',
                'billet',
                'ticket',
                'money',
                'argent',
                'cher',
                'supérieur',
                'inférieur',
                'higher',
                'lower'
            ]
        ],
        [
            'title'   => 'Pourquoi le prix de revente maximum autorisé ne prend pas en compte mes frais supplémentaires dûs à une modification du billet au préalable ?',
            'content' => 'Le prix de revente maximum légal, est le prix d’achat INITIAL. Il ne prend pas en compte les différents frais de changements qui pourraient avoir lieu une fois le billet acheté.',
            'tags'    => [
                'prix',
                'price',
                'billet',
                'ticket',
                'money',
                'argent',
                'cher',
                'supérieur',
                'inférieur',
                'higher',
                'lower'
            ]
        ],
        [
            'title'   => 'Puis-je revendre un aller retour ensemble ? ',
            'content' => 'Non, afin d’augmenter les chances de revendre vos billets, chaque billet est vendu séparément sur PasseTonBillet.fr. ',
            'tags'    => [
                'AR',
                'A/R',
                'aller',
                'retour',
                'deux',
                'billets',
                'tickets',
                'return',
                'one way',
                'simple',
                'aller'
            ]
        ],
        [
            'title'   => 'Puis-je revendre un billet qui n’est pas à mon nom ?',
            'content' => 'Pour des raisons de sécurité, il n’est pas possible de revendre un billet acheté initialement sous un autre nom. Si vous souhaitez revendre un billet appartenant à un de vos proches et que vous avez toutes ses informations personnelles ainsi qu’une copie d’une des ses pièces d’identité, nous vous invitons à lui créer un compte et à gérer la vente pour celui-ci. Si ce n’est pas le cas, vous pouvez toujours le remettre en vente sur notre groupe Facebook dédié qui contient plus de 50 000 acheteurs et revendeurs: https://www.facebook.com/groups/eurostarpassetonbillet/',
            'tags'    => [
                'nom',
                'name',
                'Facebook',
                'change',
                'update',
                'find',
                'corriger',
                'fix',
                'famille',
                'last',
                'pas',
                'mon',
                'not',
                'different',
                'mine',
                'mien'
            ]
        ],
        [
            'title'   => 'Est-ce risqué de partager mon RIB dans une conversation ?',
            'content' => 'Non. La simple détention d’un relevé d’identité bancaire ou d’un IBAN ne permet pas de débiter votre compte. Uniquement de le créditer. La simple possession de ces informations ne vaut pas une autorisation de prélèvement.',
            'tags'    => [
                'RIB',
                'bank',
                'risky',
                'risque',
                'info',
                'details',
                'banque',
                'IBAN',
                'sort',
                'code',
                'account',
                'number'
            ]
        ],
        [
            'title'   => 'Comment puis-je modifier le prix d’un billet que je revends ?',
            'content' => 'Pour modifier le prix d’un billet que vous vendez, allez dans ‘Mes Billets’, puis cliquez sur le bouton ‘Modifier’ sur le billet que vous souhaitez modifier, puis choisissez le nouveau prix auquel vous souhaitez revendre le billet.',
            'tags'    => [ 'modifier', 'edit', 'price', 'prix', 'billet', 'ticket', 'on', 'sale', 'en', 'vente' ]
        ],
        [
            'title'   => 'Comment puis-je supprimer un billet que je revends ou indiquer qu’il a été vendu en dehors de PasseTonBillet.fr ?',
            'content' => 'Si un billet que vous revendez n’est plus disponible, il est impératif que vous le supprimiez immédiatement. Pour le supprimer, allez dans ‘Mes Billets’, puis cliquez sur ‘Modifier’ sur le billet que vous souhaitez supprimer, puis cliquez sur ‘Supprimer le billet’. Enfin choisissez la raison pour laquelle vous souhaitez le supprimer de PasseTonBillet.fr et il sera alors immédiatement retiré de la vente.
            <br><b>IMPORTANT: Ne supprimez pas un billet qui a été vendu sur PasseTonBillet.fr, vous devez simplement cliquer sur ‘Transaction Terminée’ en haut de la conversation avec l’acheteur de ce billet et votre billet sera automatiquement retiré de la vente et marqué comme vendu.</b>',
            'tags'    => [
                'supprimer',
                'delete',
                'remove',
                'cancel',
                'sold',
                'vendu',
                'autre',
                'part',
                'somewhere',
                'else'
            ]
        ],
        [
            'title'   => 'Qu’est ce-qu’un lien direct de partage de billet ?',
            'content' => 'Un lien direct de partage de billet, est un lien internet créé spécifiquement pour votre billet en vente et qui vous permet de le partager facilement sur les réseaux sociaux ou sur d’autres sites. Si un utilisateur est intéressé par votre billet, il n’aura qu’à cliquer sur le lien et pourra vous faire une offre directement pour votre billet !',
            'tags'    => [
                'lien',
                'directe',
                'direct',
                'link',
                'share',
                'partager',
                'groupe',
                'group',
                'Facebook',
                'send',
                'envoyer',
                'billet',
                'ticket'
            ]
        ],
        [
            'title'   => 'Comment obtenir un lien direct de partage pour mon billet ?',
            'content' => 'Pour obtenir votre lien direct de partage pour un billet que vous revendez, allez dans ‘Mes Billets’, puis cliquez sur le bouton ‘Partager’ en haut à gauche du billet que vous souhaitez partager. Puis cliquez sur ‘Copier le lien’ afin que vous puissiez le coller où vous le souhaitez ! Nous conseillons de le publier sur tous les groupes Facebook de revente de billets Eurostar afin de maximiser vos chances de revendre votre billet rapidement !',
            'tags'    => [
                'lien',
                'directe',
                'direct',
                'link',
                'share',
                'partager',
                'groupe',
                'group',
                'Facebook',
                'send',
                'envoyer',
                'billet',
                'ticket'
            ]
        ],
        [
            'title'   => 'Comment acheter un billet ?',
            'content' => 'Pour acheter un billet, vous devez d’abord créer un compte, puis choisir le billet qui vous intéresse, soit en utilisant le moteur de recherche de la plateforme, soit en cliquant sur un lien direct de billet.<br> 
            Une fois que vous avez trouvé un billet qui vous intéresse, vous devez faire une offre inférieure ou égale au prix de revente du billet. Le vendeur du billet va alors être automatiquement notifié, et pourra accepter ou refuser votre offre:
            <ul><li>S’il accepte votre offre, vous serez alors notifié par email et une conversation avec le vendeur sera alors automatiquement créée dans ‘Offres’ dans laquelle vous pourrez vous mettre d’accord sur le moyen de paiement qui vous convient le mieux à tous les deux. Une fois que le vendeur aura reçu votre paiement, il aura simplement à cliquer sur "Transaction Terminée" en haut de votre conversation et vous recevrez automatiquement son billet unique par mail. Le billet sera également automatiquement retiré de la vente et les autres conversations concernant ce billet seront terminées.</li><li>S’il refuse votre offre, vous pourrez alors faire une contre-offre à un prix supérieur à celui proposé lors de la première offre ou tout simplement choisir un autre billet.</li></ul>
            <br><b>IMPORTANT: faire une offre pour un billet ne vous engage pas à devoir l’acheter. Ainsi, vous pouvez faire des offres pour plusieurs billets à la fois. </b>',
            'tags'    => [
                'acheter',
                'buy',
                'ticket',
                'buy ticket',
                'acheter un billet',
                'offre',
                'offer',
                'have to',
                'dois-je'
            ]
        ],
        [
            'title'   => 'Est-il possible de contacter un vendeur directement ?',
            'content' => 'Non, pour des raisons de sécurité, il n’est pas possible de contacter un vendeur directement. Le seul moyen de contacter un vendeur de la plateforme est dans les conversations créées dans ‘Offres’ une fois que le vendeur a accepté votre offre. Nous ne communiquerons en aucun cas les numéros de téléphone des vendeurs.',
            'tags'    => [
                'contacter',
                'contact',
                'seller',
                'vendeur',
                'contact directly',
                'contacter directment',
                'rapidement',
                'rapide',
                'quicker',
                'quick'
            ]
        ],
        [
            'title'   => 'Je me suis connecté avec Facebook, mon nom de famille est incorrect. Comment puis-je le changer ?',
            'content' => 'Pas d’inquiétude, si vous avez déjà soumis une copie d’une pièce d’identité pour vérification votre nom, prénom et date de naissance seront automatiquement mis à jour avec vos informations officielles. Si ce n’est toujours pas le cas après vérification de votre profil, merci de nous contacter directement. Si vous n’avez pas encore soumis une copie d’une pièce d’identité pour vérification de votre compte, nous invitons à le faire en allant dans ‘Mon Profil’ > ‘Vérifier mon compte’.',

            'tags' => [
                'facebook connect',
                'connexion avec facebook',
                'nom',
                'surname',
                'change surname',
                'family name',
                'change family name',
                'nom de famille',
                'changer nom de famille',
                'changer nom',
                'mauvais',
                'incorrect'
            ]
        ],
        [
            'title'   => 'Comment puis-je voir combien de billets un vendeur a vendu avec succès ?',
            'content' => 'Il vous suffit de cliquer sur son nom dans la partie inférieur (blanche) d’un billet. Vous aurez alors accès à toutes les informations disponibles sur le vendeur. ',
            'tags'    => [
                'seller',
                'vendeur',
                'combien de billets vendu',
                'how many ticket sold',
                'trust seller',
                'fiabilité vendeur',
                'sécurité',
                'safety',
                'safe',
                'check',
                'vérifier'
            ]
        ],
        [
            'title'   => 'Comment créer une alerte pour un billet ?',
            'content' => 'Pour créer une alerte pour un billet, il vous suffit d’effectuer une recherche pour le trajet de votre choix, puis de cliquer sur ‘Créer une alerte’ en haut des résultats de la recherche. Entrez votre adresse email ainsi que les critères de votre recherche, et l’alerte sera automatiquement créée. Vous serez alors immédiatement notifié par email lorsqu’un vendeur mettre en vente un billet qui correspond à ce que vous recherchez. 
                Si vous avez déjà un compte, vous pouvez retrouver vos alertes et les modifier ou en créer de nouvelles en allant dans ‘Mes Alertes’.',
            'tags'    => [
                'créer',
                'create',
                'notify',
                'notification',
                'alert',
                'alerte',
                'alerts',
                'alertes',
                'notifié',
                'recherche',
                'introuvable',
                'know',
                'when',
                'new',
                'savoir',
                'quand',
                'nouveau',
                'pas'
            ]
        ],
        [
            'title'   => 'Comment recevoir mon billet ?',
            'content' => 'Lorsque le vendeur aura reçu votre paiement pour son billet, il vous suffit devra impérativement cliquer sur ‘Transaction Terminée’ en haut de la conversation avec vous. Vous recevrez alors automatiquement votre billet par email, et celui-ci sera alors immédiatement retiré de la vente et toutes les conversations avec d’autres acheteurs intéressés par ce billet seront terminées.
                <br><b>IMPORTANT: Merci de bien vérifier que vous avez bien reçu le paiement de l’acheteur sur votre compte correspondant et de ne pas vous contenter d’une capture d’écran de confirmation ou d’un email Paypal envoyé par l’acheteur. ',
            'tags'    => [ 'recevoir', 'receive', 'get', 'my', 'ticket', 'mon', 'billet', 'mail', 'buy', 'acheter' ]
        ],
        [
            'title'   => 'Comment puis-je être certain que les billets en vente sont valides ?',
            'content' => 'Chaque billet mis en vente sur la PasseTonBillet.fr est préalablement vérifié dans la base de données du fournisseur de billet concerné (Eurostar, Thalys ou SNCF). Nous vérifions que le billet existe et est bien valide, ainsi que le fait qu’il a bien été acheté par l’utilisateur qui souhaite le revendre sur PasseTonBillet.fr.',
            'tags'    => [
                'certain',
                'know',
                'secure',
                'security',
                'safe',
                'sécurisé',
                'sécurisée',
                'sécurité',
                'valid',
                'valide',
                'billet',
                'ticket'
            ]
        ],
        [
            'title'   => 'Pourquoi les profils sont-ils vérifiés ?',
            'content' => 'Chaque vendeur est soumis à une vérification d’identité, afin que l’on puisse confirmer que les informations enregistrées (nom, prénom et date de naissance) sont correctes.',
            'tags'    => [
                'verification',
                'vérification',
                'check',
                'ID',
                'identity',
                'identité',
                'profil',
                'compte',
                'validé',
                'valide',
                'name'
            ]
        ],
        [
            'title'   => 'Un vendeur non vérifié vend un billet qui m’intéresse, devrais-je lui faire une offre ?',
            'content' => 'Nous déconseillons de faire des offres aux utilisateurs non vérifiés car cela signifie que nous avons pas pu vérifié les informations du vendeur. Cependant, vous pouvez voir si le vendeur est en cours de vérification, et dans ce cas là, cela ne présente aucun signe de suspicion et son profil devrait être vérifié d’ici quelques minutes.',
            'tags'    => [
                'verification',
                'vérification',
                'check',
                'ID',
                'identity',
                'identité',
                'profil',
                'compte',
                'validé',
                'valide',
                'name'
            ]
        ],
        [
            'title'   => 'Comment puis-je être certain que le vendeur va m’envoyer le billet une fois qu’il aura reçu mon paiement ?',
            'content' => 'Nous prenons très au sérieux la sécurité de nos utilisateurs. Une fois le paiement reçu, le vendeur doit impérativement cliquer sur le bouton ‘Transaction Terminée’, cela enverra automatiquement le billet à l’acheteur. Si un vendeur ne suit pas les règles le billet, nous le bannirons définitivement, et le reporterons à la police directement.',
            'tags'    => [
                'certain',
                'for',
                'sure',
                'security',
                'sécurité',
                'recevoir',
                'receive',
                'send',
                'envoyer',
                'billet',
                'ticket',
                'seller',
                'vendeur'
            ]
        ],
        [
            'title'   => 'Puis-je annuler ou modifier une offre déjà envoyé à un acheteur ?',
            'content' => 'Non, une fois qu’une offre est envoyée, il est impossible de la modifier ou de l’annuler. Mais pas d’inquiétude, envoyer une offre ne vous engage pas à acheter le billet. Par conséquent si le le vendeur accepte votre offre, vous n’aurez qu’à lui signaler que vous n’êtes plus intéressé par son billet dans la conversation qui sera automatiquement créée. 
                Si le vendeur refuse votre offre, mais que vous souhaitez toujours acheter le billet, vous pourrez lui soumettre une nouvelle offre.',
            'tags'    => [ 'annuler', 'cancel', 'edit', 'modifier', 'offre', 'offer' ]
        ],
        [
            'title'   => 'Le site est-il vraiment 100% gratuit ?',
            'content' => 'Oui ! Le site est 100% gratuit pour tous les vendeurs et acheteurs, nous ne prenons aucun frais pendant toute la durée du processus de revente.',
            'tags'    => [ 'gratuit', 'free', 'fees', 'frais', 'payant', 'pay', 'money' ]
        ],
        [
            'title'   => 'Comment signaler un utilisateur suspicieux ?',
            'content' => 'Si vous rencontrez un utilisateur suspicieux, merci de nous le faire savoir très rapidement sur le live chat ou bien par email à contact@passetonbillet.fr. Nous investigueront dans les plus brefs délais pour garantir la sécurité de nos utilisateurs.',
            'tags'    => [
                'signaler',
                'report',
                'scam',
                'fraud',
                'issue',
                'fraudeur',
                'fake',
                'faux',
                'problem',
                'issue',
                'problème'
            ]
        ],
        [
            'title'   => 'Pourquoi est-il important de discuter dans les conversations créées par PasseTonBillet.fr ?',
            'content' => 'Il est impératif de discuter dans les conversations créées par la plate-forme afin que nous puissions accéder aux échanges entre les utilisateurs et intervenir dans en cas de problèmes.',
            'tags'    => [
                'signaler',
                'report',
                'scam',
                'fraud',
                'issue',
                'fraudeur',
                'fake',
                'faux',
                'problem',
                'issue',
                'problème'
            ]
        ],
    ]

];
