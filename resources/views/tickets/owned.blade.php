@extends('layouts.dashboard')

@section('title')
    - My Tickets
@endsection

@section('dashboard-content')
    <div class="container">
        <div class="row" id="owned-tickets">
            <my-tickets :default-state="child.owned_tickets.defaultState"></my-tickets>
        </div>
    </div>
@endsection

@push('vue-data')

    <script type="text/javascript">
        @if (session('addedTicket'))
            currentPage.data.addedTicket = {!! json_encode(session()->pull('addedTicket')) !!}
        @endif
            data.owned_tickets = {
            defaultState: {!! json_encode($state) !!}
        }
    </script>
@endpush