@component('mail::message')
# Hello  {{$user->first_name}} !

Someone sent you an offer for this ticket:

@component('mail::ticket',['ticket'=>$ticket, 'lang'=>'en'])
@endcomponent

@component('mail::button', ['url' => route('home'),'color'=>'blue'])
Check out offer
@endcomponent

@endcomponent
