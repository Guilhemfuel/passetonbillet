@component('mail::message')

    # Hello  {{$user->first_name}} !

    You can find your ticket in your file attachment, or download here, make sure to be connected to make it works.

@component('mail::button', ['url' =>route('public.ticket.download',[$ticket->id]),'color'=>'blue'])
    Download here
@endcomponent

@endcomponent