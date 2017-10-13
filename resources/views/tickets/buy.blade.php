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

            ]
        ];
        $api = [
            'tickets' => [
                'buy' => route('api.tickets.buy')
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