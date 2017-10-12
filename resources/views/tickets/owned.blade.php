@extends('layouts.dashboard')

@section('dashboard-content')
    <div class="container-fluid">
        <div class="row" id="owned-tickets">
            <my-tickets :lang="lang" :user="user" :tickets="tickets" :csrf="csrf" :routes="routes"></my-tickets>
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
        var ownedTicket = new Vue({
            el: '#owned-tickets',
            data: {
                lang: {!!json_encode($lang)!!},
                user: {!! json_encode($user) !!},
                tickets: {!! json_encode($tickets) !!},
                csrf: '{!! csrf_token() !!}',
                routes: {!! json_encode($routes) !!}
            }
        });
    </script>
@endpush