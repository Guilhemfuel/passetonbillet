@component('mail::message')
# Hello  {{$user->full_name}} !

Cliquez sur le bouton pour ré-initialiser votre mot de passe.

@component('mail::button', ['url' => route('password.reset.page',['token'=>$token]),'color'=>'green'])
Ré-initialiser votre mot de passe
@endcomponent

@endcomponent
