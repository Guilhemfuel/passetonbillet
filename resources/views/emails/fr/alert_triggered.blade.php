@component('mail::message')
# Hello  {{$user?$user->first_name:""}} !

Bonne nouvelle, un nouveau billet {{$alert->departureStation->name}} → {{$alert->arrivalStation->name}} a été publiée pour le {{$train->carbon_departure_date->format('d/m/Y')}}.

@component('mail::button', ['url' => $link,'color'=>'blue'])
Voir le nouveau billet
@endcomponent

Vous ne souhaitez-plus recevoir d'emails pour cette alerte? [Cliquez-ici pour la supprimer]({{route('public.alert.delete',[$alert->id,$alert->hash])}}).

@endcomponent
