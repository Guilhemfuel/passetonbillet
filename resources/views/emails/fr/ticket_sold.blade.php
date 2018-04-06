@component('mail::message')

# Hello  {{$user->first_name}} !

{{$discussion->seller->full_name}} vous a envoyé son billet:

@component('mail::ticket',['ticket'=>$discussion->ticket,'discussion'=>$discussion, 'lang'=>'fr'])
@endcomponent

@endcomponent
