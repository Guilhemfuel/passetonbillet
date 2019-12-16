@component('mail::message')

    # Hello  {{$user->first_name}} !

    Someone bought your ticket {{ $ticket->train->departureCity->name }} - {{ $ticket->train->arrivalCity->name }}.
    Your payment will be complete after {{ $ticket->train->departure_date->addDays(1)->format( 'j F Y' ) }}.
    Make sure to complete your IBAN Account and you upload your ID to receive your payment.

@component('mail::button', ['url' =>route('home'),'color'=>'blue'])
    Complete here
@endcomponent

@endcomponent