@extends('layouts.dashboard')

@section('dashboard-content')
    <div class="container-fluid">
        <div class="row" id="sell-ticket">
            <sell-ticket :api="api" :lang="lang"></sell-ticket>
        </div>
    </div>
@endsection

@push('scripts')
    <?php
    $lang = Lang::get( 'tickets.sell' );
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
            }
        });
    </script>
@endpush