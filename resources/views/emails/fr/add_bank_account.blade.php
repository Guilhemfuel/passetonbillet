@component('mail::message')
    # Bonjour  {{$user->first_name}} !

    Vous devez ajouter un compte bancaire pour recevoir votre argent

@component('mail::button', ['url' =>route('public.ticket.payment.page'),'color'=>'blue'])
Ajouter un compte bancaire
@endcomponent

@endcomponent
