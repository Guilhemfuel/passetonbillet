@component('mail::message')

    # Bonjour  {{$user->first_name}} !

    Quelqu'un vient d'acheter votre ticket {{ $ticket->train->departureCity->name }} - {{ $ticket->train->arrivalCity->name }}.
    La transaction sera complète à partir du {{ $ticket->train->departure_date->addDays(1)->format( 'j F Y' ) }}.
    Assurez vous de compléter votre IBAN ainsi que de vérifier votre identité pour recevoir votre paiement.

@component('mail::button', ['url' =>route('home'),'color'=>'blue'])
    Complétez le ici
@endcomponent

@endcomponent