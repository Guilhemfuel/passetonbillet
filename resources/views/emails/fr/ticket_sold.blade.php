@component('mail::message')

# Hello  {{$user->first_name}} !

{{$discussion->seller->full_name}} vous a vendu son billet:

@component('mail::ticket',['ticket'=>$discussion->ticket,'discussion'=>$discussion,'download'=>false, 'lang'=>'fr'])
@endcomponent

Malheureusement nous n'avons pas réussi à récupérer le PDF du billet. Merci de demander au vendeur de vous l'envoyer si ce n'est pas déjà fait !

@endcomponent
