@component('mail::message')
# Hello  {{$user->full_name}} !

Just click the button to reset your password.

@component('mail::button', ['url' => route('password.reset.page',['token'=>$token]),'color'=>'green'])
Reset your password
@endcomponent

@endcomponent
