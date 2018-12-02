@component('mail::message')
# Hello  {{$user->first_name}} !

Welcome on PasseTonBillet, the safest place to buy and sell train tickets.

You are looking for a ticket? (Click here to find a cheap train ticket)[{{route('home')}}]

You want to sell your ticket? (Click here to put it for sale in 1 min)[{{route('public.ticket.sell.page')}}]


@endcomponent
