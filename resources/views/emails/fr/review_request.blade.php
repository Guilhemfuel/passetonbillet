@component('mail::message')

# Hello  {{$user->first_name}} !

Nous sommes ravis d'avoir pu vous aider à revendre votre billet vers {{$ticket->train->arrivalCity->name}}!
Pourriez-vous nous laisser une note de 1 à 5 décrivant votre expérience en tant que vendeur en cliquant sur le bouton ci-dessous?
PasseTonBillet.fr s'améliore de jour en jour grâce aux retours de nos utilisateurs. Nous vous remercions de votre contribution.
🙂
@component('mail::button', ['url' => route('home') . '#review', 'color'=>'blue'])
    Laisser mon avis en 1 minute
@endcomponent


@endcomponent