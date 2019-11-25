@component('mail::message')
    # Bonjour  {{$user->first_name}} !

    Vous devez nous envoyer un document pour valider votre compte :

@component('mail::button', ['url' =>route('public.profile.home'),'color'=>'blue'])
    Vérifier son identité
@endcomponent

@endcomponent
