@component('mail::message')

# Hello  {{$user->first_name}} !

We are excited see you have been able to help you resell your ticket to {{$ticket->train->arrivalCity->name}}!
Could you leave us a rating of 1 to 5 describing your experience as a seller by clicking the button below?
PasseTonBillet.fr is improving day by day thanks to feedback from our users. We thank you for your contribution.

@component('mail::button', ['url' => route('home') . '#review', 'color'=>'blue'])
    Have your say
@endcomponent


@endcomponent