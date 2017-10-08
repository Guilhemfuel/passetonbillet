@extends('layouts.dashboard')

@section('dashboard-content')
    <div class="container">
        <div class="row mt-4" id="test">
            <div class="col-sm-12 col-md-6 col-lg-4">
                <ticket :ticket="ticket" :lang="lang"></ticket>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    <?php
        $lang = Lang::get( 'tickets.component' );
        $ticket = \App\Ticket::find(50);
    ?>

    <script type="text/javascript">
        var ticketDisplay = new Vue({
            el: '#test',
            data: {
                ticket: {!! json_encode( new \App\Http\Resources\TicketRessource( $ticket ) )!!},
                lang: {!!json_encode($lang)!!}
            }
        });
    </script>
@endpush
