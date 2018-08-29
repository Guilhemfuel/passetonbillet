@component('mail::message')
# Hello  {{$user->first_name}} !

Unfortunately we couldn't confirm your identity for the following reasons:

{{$comment}}

See you soon on Ptb!

@endcomponent
