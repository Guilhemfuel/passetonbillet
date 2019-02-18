@component('mail::message')

# Hello  {{$user->first_name}} !

Chez PasseTonBillet, nous voulons offrir la meilleure expérience possible à un client et réduire
sur les escroqueries et les activités frauduleuses. Cela peut parfois être difficile à réaliser sans expérience de première main.
C'est pourquoi nous sollicitons votre aide pour rendre cela possible.
Nous sommes ravis que vous ayez récemment vendu un billet et nous aimerions en savoir plus sur votre expérience avec PasseTonBillet.
Veuillez cliquer sur le lien ci-dessous pour prendre 5 minutes pour remplir notre formulaire de commentaires et fournir des suggestions ou des domaines que vous pensez pouvoir améliorer.

@component('mail::button', ['url' => route('home') . '#review', 'color'=>'blue'])
    Votre avis
@endcomponent


@endcomponent