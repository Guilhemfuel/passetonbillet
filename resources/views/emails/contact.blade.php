@component('mail::message')
# Hello !

{{$name}} veut nous contacter. Son email: {{$email}}

Son Message:

@component('mail::panel')
    {{ $message }}
@endcomponent

@endcomponent
