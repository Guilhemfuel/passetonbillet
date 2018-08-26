@extends('layouts.dashboard')

@section('title')
    - Buy Ticket
@endsection

@section('dashboard-content')
    <div class="container-fluid">
        <div class="row" id="buy-ticket">
            <buy-ticket :default-search="child.buy.search"></buy-ticket>
        </div>
    </div>
@endsection

@push('vue-data')
    <script type="application/javascript">
        data.buy = {
            search: {!! json_encode($search) !!}
        }
    </script>
@endpush
