@extends('layouts.dashboard')

@section('title')
    - My Tickets payments
@endsection

@section('dashboard-content')
    <div class="container">
        <div class="row" id="owned-tickets">
            <my-tickets-payments></my-tickets-payments>
        </div>
    </div>
@endsection

@push('vue-data')
    <script type="text/javascript">

    </script>
@endpush