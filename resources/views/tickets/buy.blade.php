@extends('layouts.dashboard')

@section('dashboard-content')
    <div class="container-fluid">
        <div class="row" id="buy-ticket">
            <buy-ticket :lang="child.buy_ticket.lang" :user="user" :routes="child.buy_ticket.routes" :api="child.buy_ticket.api" :stations="child.buy_ticket.stations"></buy-ticket>
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
            data.buy_ticket = {
                lang: {!!json_encode($lang)!!},
                routes: {!! json_encode($routes) !!},
                api: {!! json_encode($api) !!},
                stations: {!! json_encode($stations) !!}
            }
    </script>
@endpush