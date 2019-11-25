@component('mail::message')
    # Bonjour  {{$user->first_name}} !

    Une erreur s'est produite pendant le virement de votre argent, contactez-nous pour en savoir plus.

@component('mail::button', ['url' =>route('home'),'color'=>'blue'])
Passe Ton Billet
@endcomponent

@endcomponent
