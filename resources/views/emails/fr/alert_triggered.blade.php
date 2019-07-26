@component('mail::message')
# Hello  {{$user?$user->first_name:""}} !

Bonne nouvelle, un nouveau billet {{$alert->departureStation->name}} → {{$alert->arrivalStation->name}} a été publiée pour le {{$alert->travel_date->format('d/m/Y')}}.

@component('mail::button', ['url' => $alert->link,'color'=>'blue'])
Voir le nouveau billet
@endcomponent

@endcomponent
