@component('mail::message')
    # Bonjour  {{$user->first_name}} !

    Votre compte n'a pas été vérifié, vous pouvez envoyer de nouveaux documents ici :

@component('mail::button', ['url' =>route('public.profile.home'),'color'=>'blue'])
    Envoyer un document
@endcomponent

@endcomponent
