@extends('layouts.dashboard')

@section('dashboard-content')
    <div class="container-fluid">
        <div class="row" id="sell-ticket">
            <sell-ticket :api="api" :lang="lang" :user="user" :csrf="csrf" :routes="routes"></sell-ticket>
        </div>
    </div>
@endsection

@push('scripts')
    <?php
        $lang = Lang::get( 'tickets' );
        $routes = [
            'tickets' => [
                'sell' => route('public.ticket.sell.post')
            ]
        ]
    ?>

    <script type="text/javascript">
        var sellTicket = new Vue({
            el: '#sell-ticket',
            data: {
                api: {
                    tickets: {
                        search: '{!! route('api.tickets.search') !!}'
                    }
                },
                lang: {!!json_encode($lang)!!},
                user: {!! json_encode($user) !!},
                csrf: '{!! csrf_token() !!}',
                routes: {!! json_encode($routes) !!}

            }
        });
    </script>
@endpush