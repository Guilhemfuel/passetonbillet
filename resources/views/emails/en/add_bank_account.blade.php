@component('mail::message')
    # Hello  {{$user->first_name}} !

    You need to add a bank account to receive your money !

@component('mail::button', ['url' =>route('public.ticket.payment.page'),'color'=>'blue'])
Add bank account
@endcomponent

@endcomponent
