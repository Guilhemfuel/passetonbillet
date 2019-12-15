@component('mail::message')
# Hello  {{$user->first_name}} !

Just one more step...
@component('mail::button', ['url' => route('register.verify-email',$user->email_token),'color'=>'blue'])
Activate your account
@endcomponent

@endcomponent
