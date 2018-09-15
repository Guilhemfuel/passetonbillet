@extends('layouts.dashboard')

@section('title')
    - My Tickets
@endsection

@section('dashboard-content')
    <div class="container">
        <div class="row" id="owned-tickets">
            <my-tickets :lang="child.owned_tickets.lang" :user="user" :tickets="child.owned_tickets.tickets" :bought-tickets="child.owned_tickets.boughtTickets"
                        :offer-sent="child.owned_tickets.offerSent" :api="child.owned_tickets.api"
                        :routes="child.owned_tickets.routes" :default-state="child.owned_tickets.defaultState"></my-tickets>
        </div>
    </div>
@endsection

<?php
    $lang = Lang::get( 'tickets' );
    $routes = [
        'tickets' => [
            'sell'         => route( 'public.ticket.sell.post' ),
            'delete'       => route( 'public.ticket.delete' ),
            'share'        => route( 'ticket.unique.page', [ 'ticket_id' => 'ticket_id' ] ),
            'sell_page'    => route( 'public.ticket.sell.page' ),
            'buy_page'     => route( 'public.ticket.buy.page' ),
            'discuss_page' => route( 'public.message.discussion.page', [
                'ticket_id'     => 'ticket_id',
                'discussion_id' => 'discussion_id'
            ] )
        ]
    ];
    $api = [
        'tickets' => [
            'buy' => route('api.tickets.buy'),
            'offer' => route('api.tickets.offer')
        ]
    ];
?>

@push('vue-data')

    <script type="text/javascript">
        data.owned_tickets = {
            lang: {!!json_encode($lang)!!},
            tickets: {!! json_encode($tickets) !!},
            boughtTickets:  {!! json_encode($boughtTickets) !!},
            routes: {!! json_encode($routes) !!},
            api: {!! json_encode($api) !!},
            offerSent: {!! json_encode($offerSent) !!},
            defaultState: {!! json_encode($state) !!}
        }
    </script>
@endpush