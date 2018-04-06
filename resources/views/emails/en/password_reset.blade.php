@component('mail::message')
# Hello  {{$user->first_name}} !

Just click the button to reset your password.

@component('mail::button', ['url' => route('password.reset.page',['token'=>$token]),'color'=>'blue'])
Reset your password
@endcomponent

@endcomponent
