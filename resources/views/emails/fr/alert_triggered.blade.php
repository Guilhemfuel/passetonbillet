@component('mail::message')
# Hello  {{$user?$user->first_name:""}} !

Bonne nouvelle, un nouveau billet {{$alert->departureStation->name}} → {{$alert->arrivalStation->name}} a été publiée pour le {{$train->carbon_departure_date->format('d/m/Y')}}.

@component('mail::button', ['url' => $link,'color'=>'blue'])
Voir le nouveau billet
@endcomponent

@endcomponent
