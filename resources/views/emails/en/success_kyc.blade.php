@component('mail::message')
    # Hello  {{$user->first_name}} !

    Your account has been verified !

@component('mail::button', ['url' =>route('home'),'color'=>'blue'])
Passe Ton Billet
@endcomponent

@endcomponent
