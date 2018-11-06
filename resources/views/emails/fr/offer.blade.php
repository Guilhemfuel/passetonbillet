@component('mail::message')
# Hello  {{$user->first_name}} !

Vous avez reçu une offre pour ce billet:

@component('mail::ticket',['ticket'=>$ticket, 'lang'=>'fr'])
@endcomponent

@component('mail::button', ['url' => route('home'),'color'=>'blue'])
Voir l'offre
@endcomponent

@endcomponent
