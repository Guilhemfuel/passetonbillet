@component('mail::message')
    # Hello  {{$user->first_name}} !

    We sent money to your bank account, have a nice day !

@component('mail::button', ['url' =>route('home'),'color'=>'blue'])
Passe Ton Billet
@endcomponent

@endcomponent
