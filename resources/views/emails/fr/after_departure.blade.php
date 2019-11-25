@component('mail::message')

# Bonjour  {{$user->first_name}} !

What did you think about our service ? You can let a review on our website, if you had any trouble with your ticket you can
<a href="{{route('public.ticket.bought.page')}}">make a claim here.</a>

@component('mail::button', ['url' => route('home') . '#review', 'color'=>'blue'])
Make a review
@endcomponent

@endcomponent