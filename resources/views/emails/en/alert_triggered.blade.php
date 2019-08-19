@component('mail::message')
# Hello  {{$user?$user->first_name:""}} !

Good news, a new ticket {{$alert->departureStation->name}} → {{$alert->arrivalStation->name}} has been published for the {{$alert->travel_date->format('d/m/Y')}}.

@component('mail::button', ['url' => $alert->link,'color'=>'blue'])
Check out ticket
@endcomponent

@endcomponent