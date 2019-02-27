@component('mail::message')

# Hello  {{$user->first_name}} !

{{$discussion->seller->full_name}} sold his ticket to you:

@component('mail::ticket',['ticket'=>$discussion->ticket,'discussion'=>$discussion,'download'=>false, 'lang'=>'en'])
@endcomponent

Unfortunately, we could not retrieve the PDF of the ticket. Please ask the seller to send you the PDF of the ticket if it's not already done !

@endcomponent