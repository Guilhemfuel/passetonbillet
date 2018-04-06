@component('mail::message')
# Hello  {{$user->first_name}} !

Malheuresment, votre identité n'a pas pu etre confirmée pour les raisons suivantes:

{{$comment}}

Merci pour votre confiance et à bientôt sur Lastar!

@endcomponent
