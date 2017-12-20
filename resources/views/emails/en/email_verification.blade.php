@component('mail::message')
# Hello  {{$user->full_name}} !

Just one more step...

@component('mail::button', ['url' => route('register.verify-email',['token'=>$user->email_token]),'color'=>'blue'])
Activate your account
@endcomponent

@endcomponent