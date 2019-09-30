@extends('layouts.dashboard')

@section('title')
    - Buy Ticket
@endsection

@section('dashboard-content')
    <div class="container">
        <div class="row" id="buy-ticket">
            <buy-ticket :alert-opened="child.buy.alert" :default-search="child.buy.search"></buy-ticket>
        </div>
    </div>
@endsection

@push('vue-data')
    <script type="application/javascript">
        data.buy = {
            search: {!! json_encode($search) !!},
            alert: {!! json_encode($alert) !!}
        }

        // Default date is today
        if ( data.buy.search.trip_date == null){
            data.buy.search.trip_date = new moment().format('DD/MM/YYYY');
        }

    </script>
@endpush
