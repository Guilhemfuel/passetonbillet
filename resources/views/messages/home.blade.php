@extends('layouts.dashboard')

@section('dashboard-content')
    <div class="container-fluid">
        <div class="row" id="messages">

        </div>
    </div>
@endsection

@push('scripts')
    <?php
    $lang = Lang::get( 'tickets' );
    $routes = [

    ];
    $api = [

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
