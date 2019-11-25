@component('mail::message')
    # Hello  {{$user->first_name}} !

    Your account has not been approved, you can send new document here :

@component('mail::button', ['url' =>route('public.profile.home'),'color'=>'blue'])
    Send a document
@endcomponent

@endcomponent
