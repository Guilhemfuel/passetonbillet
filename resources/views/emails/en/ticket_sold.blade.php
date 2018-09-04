@component('mail::message')

# Hello  {{$user->first_name}} !

{{$discussion->seller->full_name}} sold his ticket to you:

@component('mail::ticket',['ticket'=>$discussion->ticket,'discussion'=>$discussion, 'lang'=>'en'])
@endcomponent

@endcomponent