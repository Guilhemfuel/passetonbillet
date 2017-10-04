@component('mail::message')
# Hello  {{$user->full_name}} !

Une dernière petite étape...

@component('mail::button', ['url' => route('register.verify-email',['token'=>$user->email_token]),'color'=>'blue'])
Activer votre compte
@endcomponent

@endcomponent
