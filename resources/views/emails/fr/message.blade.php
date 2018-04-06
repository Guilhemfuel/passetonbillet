@component('mail::message')
# Hello  {{$user->first_name}} !

Quelqu'un vous a envoyé un nouveau message à propos d'un de vos billets.
@component('mail::button', ['url' =>  route('public.message.discussion.page',[$discussion->ticket_id,$discussion->id]),'color'=>'blue'])
Voir message
@endcomponent

@endcomponent
