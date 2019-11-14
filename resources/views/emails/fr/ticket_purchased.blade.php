@component('mail::message')

    # Bonjour  {{$user->first_name}} !

    Vous pouvez retrouver votre ticket dans les pièces jointes, ou le télécharger ici. Assurez vous d'être connecté pour que cela fonctionne.

@component('mail::button', ['url' =>route('public.ticket.download',[$ticket->id]),'color'=>'blue'])
    Télécharger ici
@endcomponent

@endcomponent