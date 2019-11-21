@extends('admin.layouts.app')


@section('admin-title')
    - Home
@endsection

@section('admin-content')

    <div class="row">

        <home-stat link="{{route('users.index')}}"
                   icon="fa-user-circle-o"
                   label="Users"
                   endpoint="{{route('api.admin.home.resource','userCount')}}"
        ></home-stat>
        <home-stat link="{{route('tickets.index')}}"
                   icon="fa-ticket"
                   label="Total Tickets"
                   endpoint="{{route('api.admin.home.resource','ticketCount')}}"
        ></home-stat>
        <home-stat link="{{route('tickets.index')}}"
                   icon="fa-ticket"
                   label="Current Tickets"
                   endpoint="{{route('api.admin.home.resource','currentTicketCount')}}"
        ></home-stat>
        <home-stat link="{{route('tickets.index')}}"
                   icon="fa-ticket"
                   label="Tickets Sold"
                   endpoint="{{route('api.admin.home.resource','ticketSoldCount')}}"
        ></home-stat>
        <home-stat link="{{route('offers.index')}}"
                   icon="fa-comments"
                   label="Offers"
                   endpoint="{{route('api.admin.home.resource','offerCount')}}"
        ></home-stat>
        <home-stat link=""
                   icon="fa-bell"
                   label="Total Alerts"
                   endpoint="{{route('api.admin.home.resource','alertCount')}}"
        ></home-stat>
        <home-stat link=""
                   icon="fa-bell"
                   label="Current Alerts"
                   endpoint="{{route('api.admin.home.resource','alertCurrentCount')}}"
        ></home-stat>
        <home-stat link=""
                   icon="fa-globe"
                   label="Stations"
                   endpoint="{{route('api.admin.home.resource','stationCount')}}"
        ></home-stat>
        <home-stat link=""
                   icon="fa-train"
                   label="Trains"
                   endpoint="{{route('api.admin.home.resource','trainCount')}}"
        ></home-stat>
        <home-stat link="{{route('id_check.oldest')}}"
                   icon="fa-id-card-o"
                   label="Awaiting Check"
                   endpoint="{{route('api.admin.home.resource','idVerificationCount')}}"
        ></home-stat>
        <home-stat link="{{route('claims.index')}}"
                   icon="fa-exclamation-circle"
                   label="Claims"
                   endpoint="{{route('api.admin.home.resource','claimsCount')}}"
        ></home-stat>
    </div>

@endsection