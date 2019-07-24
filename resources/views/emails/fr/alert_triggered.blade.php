@component('mail::message')
# Hello  {{$user?$user->first_name:""}} !

Bonne nouvelle, un nouveau billet {{$alert->departureStation->name}} → {{$alert->arrivalStation->name}} a été publiée pour le {{$alert->travel_date->format('d/m/Y')}}.

@if(!$user)
Inscrivez-vous dès aujourd'hui pour contacter l'acheteur en <a href="{{route('register.page')}}">cliquant ici !</a>
@endif

@component('mail::button', ['url' => $alert->link,'color'=>'blue'])
Voir le nouveau billet
@endcomponent

@endcomponent
