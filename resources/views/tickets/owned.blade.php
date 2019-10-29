@extends('layouts.dashboard')

@section('title')
    - My Tickets
@endsection

@section('dashboard-content')
    <div class="container">
        <div class="row" id="owned-tickets">
            <my-tickets :lang="child.owned_tickets.lang" :tickets="child.owned_tickets.tickets" :bought-tickets="child.owned_tickets.boughtTickets"
                        :offer-sent="child.owned_tickets.offerSent"
                        :routes="child.owned_tickets.routes" :default-state="child.owned_tickets.defaultState"></my-tickets>
        </div>
    </div>
@endsection

<?php
    $lang = Lang::get( 'tickets' );
?>

@push('vue-data')

    <script type="text/javascript">
        @if (session('addedTicket'))
            currentPage.data.addedTicket = {!! json_encode(session()->pull('addedTicket')) !!}
        @endif

            data.owned_tickets = {
            lang: {!!json_encode($lang)!!},

            tickets: {!! json_encode($tickets) !!},
            boughtTickets:  {!! json_encode($boughtTickets) !!},
            offerSent: {!! json_encode($offerSent) !!},
            defaultState: {!! json_encode($state) !!}
        }
    </script>
@endpush