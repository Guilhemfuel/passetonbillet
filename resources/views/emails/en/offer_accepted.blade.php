@component('mail::message')
# Hello  {{$user->full_name}} !

Your offer of *{{$discussion->price}} {{$discussion->currency}}* for the train *{{$discussion->ticket->train->departureCity->name}}* to {{$discussion->ticket->train->arrivalCity->name}} on {{$discussion->ticket->train->carbon_departure_date->formatLocalized('%A %d %B %Y')}} at {{$discussion->ticket->train->departure_date}}, was accepted!
@component('mail::button', ['url' => route('public.message.discussion.page',[
                $discussion->ticket->id,
                $discussion->id
            ]),'color'=>'blue'])
Start discussing now
@endcomponent

@endcomponent
