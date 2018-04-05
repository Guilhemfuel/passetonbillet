@component('mail::message')
# Hello  {{$user->full_name}} !

Votre offre de *{{$discussion->price}} {{$discussion->currency}}* pour le train de *{{$discussion->ticket->train->departureCity->name}}* à {{$discussion->ticket->train->arrivalCity->name}} le {{$discussion->ticket->train->carbon_departure_date->formatLocalized('%A %d %B %Y')}} à {{$discussion->ticket->train->departure_date}}, est acceptée!
@component('mail::button', ['url' => route('public.message.discussion.page',[
                $discussion->ticket->id,
                $discussion->id
            ]),'color'=>'blue'])
Commencer à discuter
@endcomponent

@endcomponent
