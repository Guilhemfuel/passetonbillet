@component('mail::message')
# Hello !

Une erreur sur ce billet:

@component('mail::ticket',['ticket'=>$ticket, 'lang'=>'fr'])
@endcomponent

@component('mail::button', ['url' => route('tickets.edit',$ticket->id),'color'=>'red'])
    Voir l'erreur
@endcomponent

@endcomponent
