@component('mail::message')
# Hello  {{$user->full_name}} !

Someone sent you an offer for one of the ticket you are currenctly selling!

@component('mail::button', ['url' => route('home'),'color'=>'blue'])
Check out offer
@endcomponent

@endcomponent
