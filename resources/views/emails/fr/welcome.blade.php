@component('mail::message')
# Hello  {{$user->first_name}} !

Bienvenue sur PasseTonBillet, l'endroit le plus sûr pour acheter et revendre des billets de train.

Vous cherchez un billet? Cliquez sur le bouton ci-dessous.
@component('mail::button', ['url' => route('home'), 'color' => 'blue'])
Trouver un billet pas cher
@endcomponent

Vous souhaitez vendre un billet? Cliquez sur le bouton ci-dessous.
@component('mail::button', ['url' => route('public.ticket.sell.page'), 'color' => 'green'])
Mettre un billet en vente en 1 minute
@endcomponent

@endcomponent
