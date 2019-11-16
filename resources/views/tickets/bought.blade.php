@extends('layouts.dashboard')

@section('title')
    - My Tickets bought
@endsection

@section('dashboard-content')
    <div class="container">
        <div class="row" id="owned-tickets">
            <my-tickets-bought></my-tickets-bought>
        </div>
    </div>
@endsection

@push('vue-data')
    <script type="text/javascript">

    </script>
@endpush