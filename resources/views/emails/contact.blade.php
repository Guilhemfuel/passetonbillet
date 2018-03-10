@component('mail::message')
# Hello !

{{$name}} veut nous contacter. Son email: {{$email}}

@component('mail::panel')
    {{ $message }}
@endcomponent

@endcomponent
