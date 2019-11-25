@component('mail::message')
    # Hello  {{$user->first_name}} !

    Something happened during withdraw, we can't make transfer, please contact us.

@component('mail::button', ['url' =>route('home'),'color'=>'blue'])
Passe Ton Billet
@endcomponent

@endcomponent
