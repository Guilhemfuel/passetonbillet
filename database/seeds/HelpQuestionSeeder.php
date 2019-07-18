<?php

use Illuminate\Database\Seeder;

class HelpQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $questions = [
            [
                'question_en' => 'How to resell a ticket ?',
                'question_fr' => 'Comment revendre un billet ?',
                'answer_en'   => 'To resell a ticket, you must first create an account, then click on ‘Resell a ticket‘ at the top right of the screen. Simply enter the booking reference of your ticket and it will appear. If you have multiple tickets under the same reservation, you can choose the one you want to resell by differentiating them with the unique ticket number at the top right corner of the ticket on the platform and just below the bar code on your e-billet. Once you have chosen the ticket you want to resell, you just have to enter the price at which you want to resell it and click on "Resell". Once your ticket for sale, it is visible to all other users of PasseTonBillet.fr. These can make bids worth less or equal to the resale price. When you receive an offer from a potential buyer, you will then be notified immediately via email and on the platform. You can then accept or decline the offer by going to ‘Offers‘. Buyers can also contact you directly by calling your phone number. 

            <ul><li>If you accept an offer, a conversation with the potential buyer will then be automatically created in which you can agree on the means of payment that suits you best to both. Once you have received payment from the buyer, you must click on ‘Sold to X‘ at the top of the conversation with the buyer to whom you sold the ticket. This will send the PDF of the single ticket directly to the buyer, and will remove your ticket from the sale. You will also be credited with a successful resale!
                </li><li>If you reject an offer, you must choose the reason for which you did so and the buyer will be notified, he can make a counter-offer if the ticket is still available.</li></ul>
            <br><b>IMPORTANT: Please check that you have received payment from the buyer on your account and not just a confirmation screenshot or a Paypal email sent by the buyer.</b>',
                'answer_fr'   => 'Pour revendre un billet, vous devez d’abord créer un compte, puis cliquer sur ‘Revendre un billet’ en haut à droite de l’écran. Entrez simplement la référence de réservation de votre billet et celui-ci va apparaître. Si vous avez plusieurs billets sous la même réservation, vous pouvez choisir celui que vous souhaitez revendre en les différenciant grâce au numéro de billet unique en haut à droite sur du billet sur le site, et en dessous du code bar sur votre e-billet. Une fois que vous avez choisi le billet que vous souhaitez revendre, vous n’avez plus qu’à entrer le prix auquel vous souhaitez le revendre et cliquer sur “Revendre”. Une fois votre billet en vente, il est visible par tous les autres utilisateurs de PasseTonBillet.fr. Ceux-ci peuvent vous faire des offres inférieures ou égales au prix de revente. Lorsque vous recevrez une offre d’un acheteur potentiel, vous serez alors immédiatement notifié via email et sur la plateforme. Vous pourrez alors alors accepter ou refuser l’offre en allant dans ‘Offres’. Les acheteurs peuvent également vous contacter par téléphone. 

            <ul><li>Si vous acceptez une offre, une conversation avec le potentiel acheteur sera alors automatiquement créée dans laquelle vous pourrez vous mettre d’accord sur le moyen de paiement qui vous convient le mieux à tous les deux. Une fois que vous avez reçu le paiement de l’acheteur, vous devez impérativement cliquer sur ‘Billet vendu à X’ en haut de la conversation avec l’acheteur à qui vous avez vendu le billet. Cela enverra le PDF du billet unique directement à l’acheteur, et retirera votre billet de la vente. Vous serez également crédité d’une revente avec succès ! 
                </li><li>Si vous refusez une offre, vous devez choisir la raison pour laquelle vous l’avez fait et l’acheteur sera alors averti, il pourra faire une contre-offre si le billet est toujours disponible.</li></ul>
            <br><b>IMPORTANT: Merci de bien vérifier que vous avez bien reçu le paiement de l’acheteur sur votre compte correspondant et de ne pas vous contenter d’une capture d’écran de confirmation ou d’un email Paypal envoyé par l’acheteur.</b>',
                'tags_en'     => "revendre
                vendre
                ticket
                sell ticket
                vendre un billet
                comment
                offer
                have to
                dois-je",
                'tags_fr'     => "revendre
                    vendre
                    ticket
                    sell ticket
                    vendre un billet
                    comment
                    offer
                    have to
                    dois-je",
            ],
            [
                'question_en' => 'Is it possible to contact a buyer directly ?',
                'question_fr' => 'Est-il possible de contacter un acheteur directement ?',
                'answer_en'   => 'Yes, click on ‘Buy‘ at the center of the ticket. You can then contact the seller directly by clicking on ‘Call seller‘',
                'answer_fr'   => 'Oui, cliquez sur ‘Acheter‘ au centre du billet. Vous pouvez ensuite soit contacter le vendeur directement en cliquant sur ‘Appeler le vendeur‘',
                'tags_en'     => "contacter
                    contact
                    seller
                    vendeur
                    contact directly
                    contacter directment
                    rapidement
                    rapide
                    quicker
                    quick",
                'tags_fr'     => "contacter
                    contact
                    seller
                    vendeur
                    contact directly
                    contacter directment
                    rapidement
                    rapide
                    quicker
                    quick",
            ],
            [
                'question_en' => 'I have several tickets under the same reservation, how can I choose which one I want to resell ?',
                'question_fr' => 'J’ai plusieurs billets sous la même réservation, comment puis-je choisir lequel je souhaite revendre?',
                'answer_en'   => 'Each e-ticket generated by Eurostar, SNCF or Thalys has a unique number consisting of 9 digits (‘ticket number‘) present below the bar code. On PasseTonBillet.fr, when you enter the number of a reservation containing several tickets, all the tickets under this same reservation will appear. In the top right corner of each ticket you will see his ‘ticket number‘. So you can choose the specific ticket you want to resell.',
                'answer_fr'   => 'Chaque e-billet généré par Eurostar, SNCF ou Thalys comporte un numéro unique composé de 9 chiffres (‘ticket number’) présent en dessous du code barre. Sur PasseTonBillet.fr, lorsque vous entrez le numéro d’une réservation contenant plusieurs billets, tous les billets sous cette même réservation vont apparaître. Dans le coin en haut à droite de chacun des billets vous pourrez voir son ‘numéro de billet’ (ou ticket number). Ainsi, vous pouvez choisir le billet spécifique que vous souhaitez revendre.',
                'tags_en'     => "choisir
                    choose
                    select
                    plusieurs
                    couple
                    AR
                    A/R
                    return
                    ticket
                    tickets
                    billets
                    billet
                    different
                    same
                    même
                    reservation
                    booking",
                'tags_fr'     => "choisir
                    choose
                    select
                    plusieurs
                    couple
                    AR
                    A/R
                    return
                    ticket
                    tickets
                    billets
                    billet
                    different
                    same
                    même
                    reservation
                    booking",
            ],
            [
                'question_en' => 'What are the recommended payment methods for transactions ?',
                'question_fr' => 'Quels sont les moyens de paiement conseillés pour les transactions ?',
                'answer_en'   => 'For the sake of security and speed we recommend using Paypal, Revolut, Pumpkin or Lydia for all transactions. Bank transfers between ENGLISH accounts are also advised. Bank transfers from / to a French account take several days to arrive and are therefore not recommended.',
                'answer_fr'   => 'Par soucis de sécurité et de rapidité nous conseillons d’utiliser Paypal, Revolut, Pumpkin ou Lydia pour toutes les transactions. Les virements bancaires entre comptes ANGLAIS sont également conseillés. Les virement bancaires à partir d’un/vers un compte Français prennent plusieurs jours à arriver et sont donc déconseillés.',
                'tags_en'     => "payment
                    paiement
                    moyen de paiement
                    bank
                    banque
                    argent
                    money
                    paypal
                    revolut
                    monzo
                    transfer
                    wire
                    virement
                    transaction",
                'tags_fr'     => "payment
                    paiement
                    moyen de paiement
                    bank
                    banque
                    argent
                    money
                    paypal
                    revolut
                    monzo
                    transfer
                    wire
                    virement",
            ],
            [
                'question_en' => 'How to send my ticket to the buyer ?',
                'question_fr' => 'Comment envoyer mon billet à l’acheteur ?',
                'answer_en'   => 'When you have received payment from a buyer for your ticket, simply click on ‘Sold to X‘ at the top of the conversation with this buyer. All conversations with other buyers interested in this ticket will be terminated. You can then send the PDF file, via email or any other way.
            <br><b>IMPORTANT: Please check that you have received payment from the buyer on your account and not just a confirmation screenshot or a Paypal email sent by the buyer.</b>\'',
                'answer_fr'   => 'Lorsque vous avez reçu le paiement d’un acheteur pour votre billet, il vous suffit de cliquer sur ‘Vendre billet à X’ en haut de la conversation avec cet acheteur. Votre billet sera alors immédiatement retiré de la vente et toutes les conversations avec d’autres acheteurs intéressés par ce billet seront terminées. Vous devrez ensuite envoyer le billet par email ou autre à l\'acheteur.            <br><b>IMPORTANT: Merci de bien vérifier que vous avez bien reçu le paiement de l’acheteur sur votre compte correspondant et de ne pas vous contenter d’une capture d’écran de confirmation ou d’un email Paypal envoyé par l’acheteur.</b>',
                'tags_en'     => "send
                    envoyer
                    billet
                    ticket
                    transférer
                    transfer
                    mail
                    email
                    facebook",
                'tags_fr'     => "send
                    envoyer
                    billet
                    ticket
                    transférer
                    transfer
                    mail
                    email
                    facebook",
            ],
            [
                'question_en' => 'Can I sell a round trip together ?',
                'question_fr' => 'Puis-je revendre un aller retour ensemble ?',
                'answer_en'   => 'No, to increase the chances of reselling your tickets, each ticket is sold separately on PasseTonBillet.fr.',
                'answer_fr'   => 'Non, afin d’augmenter les chances de revendre vos billets, chaque billet est vendu séparément sur PasseTonBillet.fr. ',
                'tags_en'     => "AR
                    A/R
                    aller
                    retour
                    deux
                    billets
                    tickets
                    return
                    one way
                    simple
                    aller",
                'tags_fr'     => "AR
                    A/R
                    aller
                    retour
                    deux
                    billets
                    tickets
                    return
                    one way
                    simple
                    aller",
            ],
            [
                'question_en' => 'Is it risky to share my bank details in a conversation ?',
                'question_fr' => 'Est-ce risqué de partager mon RIB dans une conversation ?',
                'answer_en'   => 'No. Simply holding a bank account or an IBAN does not allow you to debit your account. Only credit it. The mere possession of this information is not worth a debit authorization.',
                'answer_fr'   => 'Non. La simple détention d’un relevé d’identité bancaire ou d’un IBAN ne permet pas de débiter votre compte. Uniquement de le créditer. La simple possession de ces informations ne vaut pas une autorisation de prélèvement.',
                'tags_en'     => "RIB
                    bank
                    risky
                    risque
                    info
                    details
                    banque
                    IBAN
                    sort
                    code
                    account
                    number",
                'tags_fr'     => "RIB
                    bank
                    risky
                    risque
                    info
                    details
                    banque
                    IBAN
                    sort
                    code
                    account
                    number",
            ],
            [
                'question_en' => 'How can I change the price of a ticket I‘m selling ?',
                'question_fr' => 'Comment puis-je modifier le prix d’un billet que je revends ?',
                'answer_en'   => 'To change the price of a ticket you sell, go to ‘My Tickets‘, then click the ‘Edit‘ button on the ticket you want to change, then choose the new price at which you want to resell the ticket.',
                'answer_fr'   => 'Pour modifier le prix d’un billet que vous vendez, allez dans ‘Mes Billets’, puis cliquez sur le bouton ‘Modifier’ sur le billet que vous souhaitez modifier, puis choisissez le nouveau prix auquel vous souhaitez revendre le billet.',
                'tags_en'     => "modifier
                     edit 
                     price 
                     prix 
                     billet 
                     ticket 
                     on 
                     sale 
                     en 
                     vente",
                'tags_fr'     => "modifier 
                    edit
                    price 
                    prix
                    billet 
                    ticket 
                    on sale 
                    en vente",
            ],
            [
                'question_en' => 'How can I delete a ticket that I resell or indicate that it has been sold outside of PasseTonBillet.fr ?',
                'question_fr' => 'Comment puis-je supprimer un billet que je revends ou indiquer qu’il a été vendu en dehors de PasseTonBillet.fr ?',
                'answer_en'   => 'If a ticket you are reselling is no longer available, it is imperative that you delete it immediately. To delete it, go to ‘My Tickets‘, then click ‘Edit‘ on the ticket you want to delete, then click ‘Delete Ticket‘. Finally choose the reason why you want to remove it from PasseTonBillet.fr and it will be immediately removed from the sale.
            <br><b>IMPORTANT: Do not delete a ticket that has been sold on PasseTonBillet.fr, you simply have to click on ‘Transaction Completed‘ at the top of the conversation with the buyer of this ticket and your ticket will be automatically removed from the sale and marked as sold.</b>',
                'answer_fr'   => 'Si un billet que vous revendez n’est plus disponible, il est impératif que vous le supprimiez immédiatement. Pour le supprimer, allez dans ‘Mes Billets’, puis cliquez sur ‘Modifier’ sur le billet que vous souhaitez supprimer, puis cliquez sur ‘Supprimer le billet’. Enfin choisissez la raison pour laquelle vous souhaitez le supprimer de PasseTonBillet.fr et il sera alors immédiatement retiré de la vente.
            <br><b>IMPORTANT: Ne supprimez pas un billet qui a été vendu sur PasseTonBillet.fr, vous devez simplement cliquer sur ‘Transaction Terminée’ en haut de la conversation avec l’acheteur de ce billet et votre billet sera automatiquement retiré de la vente et marqué comme vendu.</b>',
                'tags_en'     => "supprimer
                    delete
                    remove
                    cancel
                    sold
                    vendu
                    autre
                    part
                    somewhere
                    else",
                'tags_fr'     => "supprimer
                    delete
                    remove
                    cancel
                    sold
                    vendu
                    autre
                    part
                    somewhere
                    else",
            ],
            [
                'question_en' => 'What is a direct ticket sharing link ?',
                'question_fr' => 'Qu’est ce-qu’un lien direct de partage de billet ?',
                'answer_en'   => 'A direct link to ticket sharing, is an internet link created specifically for your ticket for sale and that allows you to share it easily on social networks or other sites. If a user is interested in your ticket, he will only have to click on the link and will be able to make you an offer directly for your ticket !',
                'answer_fr'   => 'Un lien direct de partage de billet, est un lien internet créé spécifiquement pour votre billet en vente et qui vous permet de le partager facilement sur les réseaux sociaux ou sur d’autres sites. Si un utilisateur est intéressé par votre billet, il n’aura qu’à cliquer sur le lien et pourra vous faire une offre directement pour votre billet !',
                'tags_en'     => "lien
                    directe
                    direct
                    link
                    share
                    partager
                    groupe
                    group
                    Facebook
                    send
                    envoyer
                    billet
                    ticket",
                'tags_fr'     => "lien
                    directe
                    direct
                    link
                    share
                    partager
                    groupe
                    group
                    Facebook
                    send
                    envoyer
                    billet
                    ticket",
            ],
            [
                'question_en' => 'How to get a direct share link for my ticket ?',
                'question_fr' => 'Comment obtenir un lien direct de partage pour mon billet ?',
                'answer_en'   => 'To get your direct share link for a ticket you are reselling, go to ‘My Tickets‘ and click on the ‘Share‘ button at the top left of the ticket you want to share. Then click on ‘Copy link‘ so you can paste it where you want it! We recommend posting it on all Eurostar ticket reselling Facebook groups to maximize your chances of reselling your ticket quickly !',
                'answer_fr'   => 'Pour obtenir votre lien direct de partage pour un billet que vous revendez, allez dans ‘Mes Billets’, puis cliquez sur le bouton ‘Partager’ en haut à gauche du billet que vous souhaitez partager. Puis cliquez sur ‘Copier le lien’ afin que vous puissiez le coller où vous le souhaitez ! Nous conseillons de le publier sur tous les groupes Facebook de revente de billets Eurostar afin de maximiser vos chances de revendre votre billet rapidement !',
                'tags_en'     => "lien
                    directe
                    direct
                    link
                    share
                    partager
                    groupe
                    group
                    Facebook
                    send
                    envoyer
                    billet
                    ticket",
                'tags_fr'     => "lien
                    directe
                    direct
                    link
                    share
                    partager
                    groupe
                    group
                    Facebook
                    send
                    envoyer
                    billet
                    ticket",
            ],
            [
                'question_en' => 'How to buy a ticket ?',
                'question_fr' => 'Comment acheter un billet ?',
                'answer_en'   => 'To buy a ticket, choose the ticket that you want, either by using the search engine of the platform or by clicking on a direct ticket link. <br>
            Once you have found a ticket, click on ‘Buy‘ at the center of the ticket. You can then either contact the seller directly by clicking on ‘Call seller‘. If you are not in a hurry, you can make an offer lower than or equal to the resale price of the ticket by clicking on ‘Make an offer‘. The seller of the ticket will then be automatically notified, and may accept or refuse your offer:
            <ul><li>If he accepts your offer, you will be notified by email and a conversation with the seller will be automatically created in ‘Offers‘ in which you can agree on the payment method that suits you best to both. . Once the seller has received your payment, he will simply have to click on "Completed Transaction" at the top of your conversation and you will automatically receive his single ticket by email. The ticket will also be automatically withdrawn from the sale and the other conversations concerning this ticket will be finished.</li><li>If the seller refuses your offer, you can then make a counter-offer at a price higher than the one proposed at the first offer or just choose another ticket.</li></ul>
            <br><b>IMPORTANT: bidding for a ticket does not commit you to having to buy it. So you can bid on multiple tickets at once.</b>',
                'answer_fr'   => 'Pour acheter un billet, choisissez le billet qui vous intéresse, soit en utilisant le moteur de recherche de la plateforme, soit en cliquant sur un lien direct de billet.<br> 
            Une fois que vous avez trouvé un billet qui vous intéresse, cliquez sur ‘Acheter‘ au centre du billet. Vous pouvez ensuite soit contacter le vendeur directement en cliquant sur ‘Appeler le vendeur‘. Si vous n‘êtes pas préssé, vous pouvez lui faire une offre inférieure ou égale au prix de revente du billet en cliquant sur ‘Faire une offre‘. Le vendeur du billet va alors être automatiquement notifié, et pourra accepter ou refuser votre offre:
            <ul><li>S’il accepte votre offre, vous serez alors notifié par email et une conversation avec le vendeur sera alors automatiquement créée dans ‘Offres’ dans laquelle vous pourrez vous mettre d’accord sur le moyen de paiement qui vous convient le mieux à tous les deux. Une fois que le vendeur aura reçu votre paiement, il aura simplement à cliquer sur "Transaction Terminée" en haut de votre conversation et vous recevrez automatiquement son billet unique par mail. Le billet sera également automatiquement retiré de la vente et les autres conversations concernant ce billet seront terminées.</li><li>S’il refuse votre offre, vous pourrez alors faire une contre-offre à un prix supérieur à celui proposé lors de la première offre ou tout simplement choisir un autre billet.</li></ul>
            <br><b>IMPORTANT: faire une offre pour un billet ne vous engage pas à devoir l’acheter. Ainsi, vous pouvez faire des offres pour plusieurs billets à la fois.',
                'tags_en'     => "acheter
                    buy
                    ticket
                    buy ticket
                    acheter un billet
                    offre
                    offer
                    have to
                    dois-je",
                'tags_fr'     => "acheter
                    buy
                    ticket
                    buy ticket
                    acheter un billet
                    offre
                    offer
                    have to
                    dois-je",
            ],
            [
                'question_en' => 'I signed in with Facebook, my last name is incorrect. How can I change it ?',
                'question_fr' => 'Je me suis connecté avec Facebook, mon nom de famille est incorrect. Comment puis-je le changer ?',
                'answer_en'   => 'Do not worry, if you have already submitted a copy of an ID for verification your name, surname and date of birth will be automatically updated with your official information. If this is still not the case after checking your profile, please contact us directly.
                If you have not yet submitted a copy of an ID to verify your account, we invite you to do so by going to ‘My Profile‘> ‘Check My Account‘.',
                'answer_fr'   => 'Pas d’inquiétude, si vous avez déjà soumis une copie d’une pièce d’identité pour vérification votre nom, prénom et date de naissance seront automatiquement mis à jour avec vos informations officielles. Si ce n’est toujours pas le cas après vérification de votre profil, merci de nous contacter directement. Si vous n’avez pas encore soumis une copie d’une pièce d’identité pour vérification de votre compte, nous invitons à le faire en allant dans ‘Mon Profil’ > ‘Vérifier mon compte’.',
                'tags_en'     => "facebook connect
                    connexion avec facebook
                    nom
                    surname
                    change surname
                    family name
                    change family name
                    nom de famille
                    changer nom de famille
                    changer nom
                    mauvais
                    incorrect",
                'tags_fr'     => "facebook connect
                    connexion avec facebook
                    nom
                    surname
                    change surname
                    family name
                    change family name
                    nom de famille
                    changer nom de famille
                    changer nom
                    mauvais
                    incorrect",
            ],
            [
                'question_en' => 'How can I see how many tickets a seller has sold successfully ?',
                'question_fr' => 'Comment puis-je voir combien de billets un vendeur a vendu avec succès ?',
                'answer_en'   => 'Just click on the seller‘s name in the lower (white) part of a ticket. You will then have access to all available information about the seller.',
                'answer_fr'   => 'Il vous suffit de cliquer sur son nom dans la partie inférieur (blanche) d’un billet. Vous aurez alors accès à toutes les informations disponibles sur le vendeur.',
                'tags_en'     => "seller
                    vendeur
                    combien de billets vendu
                    how many ticket sold
                    trust seller
                    fiabilité vendeur
                    sécurité
                    safety
                    safe
                    check
                    vérifier",
                'tags_fr'     => "seller
                    vendeur
                    combien de billets vendu
                    how many ticket sold
                    trust seller
                    fiabilité vendeur
                    sécurité
                    safety
                    safe
                    check
                    vérifier",
            ],
            [
                'question_en' => 'How to receive my ticket ?',
                'question_fr' => 'Comment recevoir mon billet ?',
                'answer_en'   => 'When the seller has received your payment for his ticket, all you need to do is click on ‘Sold to X‘ at the top of the conversation with you. The ticket will be immediately removed from the sale and all conversations with other buyers interested in this ticket will be terminated. You should then give the seller your details (such as email) so that she/he can send you the PDF of the ticket.',
                'answer_fr'   => 'Lorsque le vendeur aura reçu votre paiement pour son billet, il vous suffit devra impérativement cliquer sur ‘Billet vendu à X’ en haut de la conversation avec vous. Le billet sera alors immédiatement retiré de la vente et toutes les conversations avec d’autres acheteurs intéressés par ce billet seront terminées. Vous pourrez ensuite communiquer au vendeur vos informations de contact (comme votre email) afin qu\'il/elle vous envoie le PDF du billet.',
                'tags_en'     => "recevoir
                    receive
                    get
                    my
                    ticket
                    mon
                    billet
                    mail
                    buy
                    acheter",
                'tags_fr'     => "recevoir
                    receive
                    get
                    my
                    ticket
                    mon
                    billet
                    mail
                    buy
                    acheter",
            ],
            [
                'question_en' => 'How can I be sure that tickets for sale are valid ?',
                'question_fr' => 'Comment puis-je etre certain que les billets sont valide?',
                'answer_en'   => 'Each ticket sold on the PasseTonBillet.fr is pre-verified in the database of the ticket provider concerned (Eurostar, Thalys or SNCF). We verify that the ticket exists and is valid.',
                'answer_fr'   => 'Chaque billet mis en vente sur PasseTonBillet.fr et vérifié au préalable auprès de l\'agence de voyage concernée (Eurostar, Thalys ou SNCF). Nous vérifions que le billet est valide et qu\'il existe.',
                'tags_en'     => "certain
                    know
                    secure
                    security
                    safe
                    sécurisé
                    sécurisée
                    sécurité
                    valid
                    valide
                    billet
                    ticket",
                'tags_fr'     => "certain
                    know
                    secure
                    security
                    safe
                    sécurisé
                    sécurisée
                    sécurité
                    valid
                    valide
                    billet
                    ticket",
            ],
            [
                'question_en' => 'Why are profiles verified ?',
                'question_fr' => 'Pourquoi les profils sont-ils vérifiés ?',
                'answer_en'   => 'Each seller is subject to an identity verification, so that we can confirm that the information registered (name, first name and date of birth) are correct.',
                'answer_fr'   => 'Chaque vendeur est soumis à une vérification d’identité, afin que l’on puisse confirmer que les informations enregistrées (nom, prénom et date de naissance) sont correctes.',
                'tags_en'     => "verification
                    vérification
                    check
                    ID
                    identity
                    identité
                    profil
                    compte
                    validé
                    valide
                    name",
                'tags_fr'     => "verification
                    vérification
                    check
                    ID
                    identity
                    identité
                    profil
                    compte
                    validé
                    valide
                    name",
            ],
            [
                'question_en' => 'An unverified seller sells a ticket that interests me, should I make an offer ?',
                'question_fr' => 'Un vendeur non vérifié vend un billet qui m’intéresse, devrais-je lui faire une offre ?',
                'answer_en'   => 'We do not recommend making offers to unverified users as this means that we have not been able to verify the seller‘s information. However, you can see if the seller is being checked, and in this case there is no sign of suspicion and his profile should be checked in a few minutes.',
                'answer_fr'   => 'Nous déconseillons de faire des offres aux utilisateurs non vérifiés car cela signifie que nous avons pas pu vérifié les informations du vendeur. Cependant, vous pouvez voir si le vendeur est en cours de vérification, et dans ce cas là, cela ne présente aucun signe de suspicion et son profil devrait être vérifié d’ici quelques minutes.',
                'tags_en'     => "verification
                    vérification
                    check
                    ID
                    identity
                    identité
                    profil
                    compte
                    validé
                    valide
                    name",
                'tags_fr'     => "verification
                    vérification
                    check
                    ID
                    identity
                    identité
                    profil
                    compte
                    validé
                    valide
                    name",
            ],
            [
                'question_en' => 'Can I cancel or modify an offer already sent to a buyer ?',
                'question_fr' => 'Puis-je annuler ou modifier une offre déjà envoyé à un acheteur ?',
                'answer_en'   => 'No, once an offer is submitted, it can not be edited or canceled. But do not worry, sending an offer does not commit you to buy the ticket. Therefore if the seller accepts your offer, just tell him that you are no longer interested in his ticket in the conversation that will be automatically created.
                If the seller refuses your offer, but you still want to buy the ticket, you can submit a new offer.',
                'answer_fr'   => 'Non, une fois qu’une offre est envoyée, il est impossible de la modifier ou de l’annuler. Mais pas d’inquiétude, envoyer une offre ne vous engage pas à acheter le billet. Par conséquent si le le vendeur accepte votre offre, vous n’aurez qu’à lui signaler que vous n’êtes plus intéressé par son billet dans la conversation qui sera automatiquement créée. 
                Si le vendeur refuse votre offre, mais que vous souhaitez toujours acheter le billet, vous pourrez lui soumettre une nouvelle offre.',
                'tags_en'     => "annuler
                 cancel
                  edit
                   modifier
                    offre 
                    offer",
                'tags_fr'     => "annuler
                 cancel
                  edit
                   modifier
                    offre 
                    offer",
            ],
            [
                'question_en' => 'How to report a suspicious user ?',
                'question_fr' => 'omment signaler un utilisateur suspicieux ?',
                'answer_en'   => 'If you meet a suspicious user, thank you to let us know very quickly by email to contact@passetonbillet.fr. We will investigate as soon as possible to ensure the safety of our users. However, as stated in our terms of use, in no case PasseTonBillet can be held responsible for a scam on or off the platform and so we will not provide refunds for any reason',
                'answer_fr'   => 'Si vous rencontrez un utilisateur suspicieux, merci de nous le faire savoir très rapidement par email à contact@passetonbillet.fr. Nous investigueront dans les plus brefs délais pour garantir la sécurité de nos utilisateurs. Cependant, comme indiqué dans nos conditions d‘utilisations, dans AUCUN cas PasseTonBillet ne peut être tenu responsable d‘une arnaque survenue sur la plateforme ou en dehors et ainsi nous ne fournirons AUCUN remboursement quelque soit la raison.',
                'tags_en'     => "signaler
                    report
                    scam
                    fraud
                    issue
                    fraudeur
                    fake
                    faux
                    problem
                    issue
                    problème",
                'tags_fr'     => "signaler
                    report
                    scam
                    fraud
                    issue
                    fraudeur
                    fake
                    faux
                    problem
                    issue
                    problème",
            ],

            [
                'question_en' => 'Why is it important to chat in conversations created by PasseTonBillet.fr ?',
                'question_fr' => 'Comment signaler un utilisateur suspicieux ?',
                'answer_en'   => 'It is imperative to discuss in conversations created by the platform so that we can access the exchanges between users and intervene in case of problems.',
                'answer_fr'   => 'Si vous rencontrez un utilisateur suspicieux, merci de nous le faire savoir très rapidement par email à contact@passetonbillet.fr. Nous investigueront dans les plus brefs délais pour garantir la sécurité de nos utilisateurs. Cependant, comme indiqué dans nos conditions d‘utilisations, dans AUCUN cas PasseTonBillet ne peut être tenu responsable d‘une arnaque survenue sur la plateforme ou en dehors et ainsi nous ne fournirons AUCUN remboursement quelque soit la raison.',
                'tags_en'     => "signaler
                    report
                    scam
                    fraud
                    issue
                    fraudeur
                    fake
                    faux
                    problem
                    issue
                    problème",
                'tags_fr'     => "signaler
                    report
                    scam
                    fraud
                    issue
                    fraudeur
                    fake
                    faux
                    problem
                    issue
                    problème",
            ],
            


        ];


        foreach ($questions as $question) {
            \App\Models\Content\HelpQuestion::create($question);
        }

        \App\Models\Content\HelpQuestion::updateCache();
    }
}
