@component('mail::message')

# Hello  {{$user->first_name}} !

{{$discussion->seller->full_name}} sent you his ticket:

@component('mail::ticket',['ticket'=>$discussion->ticket,'discussion'=>$discussion, 'lang'=>'en'])
@endcomponent

@endcomponent