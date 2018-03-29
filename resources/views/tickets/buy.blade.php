@extends('layouts.dashboard')

@section('dashboard-content')
    <div class="container-fluid">
        <div class="row" id="buy-ticket">
            <buy-ticket :lang="lang" :user="user" :csrf="csrf" :routes="routes" :api="api" :stations="stations"></buy-ticket>
        </div>
    </div>
@endsection

@push('scripts')
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

    <script type="text/javascript">
        var buyTicket = new Vue({
            el: '#buy-ticket',
            data: {
                lang: {!!json_encode($lang)!!},
                user: {!! json_encode($user) !!},
                csrf: '{!! csrf_token() !!}',
                routes: {!! json_encode($routes) !!},
                api: {!! json_encode($api) !!},
                stations: {!! json_encode($stations) !!}
            }
        });
    </script>
@endpush