@component('mail::message')
    # Bonjour  {{$user->first_name}} !

    Nous avons envoyés votre argent sur votre compte bancaire, passez une bonne journée !

@component('mail::button', ['url' =>route('home'),'color'=>'blue'])
Passe Ton Billet
@endcomponent

@endcomponent
