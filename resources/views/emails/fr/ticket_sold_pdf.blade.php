@component('mail::message')

# Hello  {{$user->first_name}} !

{{$discussion->seller->full_name}} vous a vendu son billet:

@component('mail::ticket',['ticket'=>$discussion->ticket,'discussion'=>$discussion,'download'=>true, 'lang'=>'fr'])
@endcomponent



@endcomponent
