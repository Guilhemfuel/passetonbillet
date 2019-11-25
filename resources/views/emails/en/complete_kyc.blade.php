@component('mail::message')
    # Hello  {{$user->first_name}} !

    You need to send us documents to confirm your identity here :

@component('mail::button', ['url' =>route('public.profile.home'),'color'=>'blue'])
    Confirm identity
@endcomponent

@endcomponent
