@component('mail::message')
    # Bonjour  {{$user->first_name}} !

    Votre compte a été vérifié !

@component('mail::button', ['url' =>route('home'),'color'=>'blue'])
Passe Ton Billet
@endcomponent

@endcomponent
