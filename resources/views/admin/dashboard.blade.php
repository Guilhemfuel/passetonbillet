@extends('admin.layouts.app')


@section('admin-title')
    - Home
@endsection

@section('admin-content')

    <div class="row">

        <div class="col-sm-3 col-xs-6 pt-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="title text-center">{{$userCount}}<br>
                        <a href="{{route('users.index')}}" class="stat-link">
                            <i class="fa fa-user-circle-o fa-2x"></i>
                        </a>
                    </h4>
                </div>
                <div class="card-body text-center">
                    Users
                </div>
            </div>
        </div>
        <div class="col-sm-3 col-xs-6 pt-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="title text-center">{{$ticketCount}}<br>
                        <a href="{{route('tickets.index')}}" class="stat-link">
                            <i class="fa fa-ticket fa-2x"></i>
                        </a>
                    </h4>
                </div>
                <div class="card-body text-center">
                    Total Tickets
                </div>
            </div>
        </div>
        <div class="col-sm-3 col-xs-6 pt-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="title text-center">{{$currentTicketCount}}<br>
                        <a href="{{route('tickets.index')}}" class="stat-link">
                            <i class="fa fa-ticket fa-2x"></i>
                        </a>
                    </h4>
                </div>
                <div class="card-body text-center">
                    Current Tickets
                </div>
            </div>
        </div>
        <div class="col-sm-3 col-xs-6 pt-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="title text-center">{{$offerCount}}<br>
                        <a href="{{route('offers.index')}}" class="stat-link">
                            <i class="fa fa-comments fa-2x"></i>
                        </a>
                    </h4>
                </div>
                <div class="card-body text-center">
                    Offers
                </div>
            </div>
        </div>
        <div class="col-sm-3 col-xs-6 pt-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="title text-center">{{$stationCount}}<br>
                        <i class="fa fa-globe fa-2x"></i>
                    </h4>
                </div>
                <div class="card-body text-center">
                    Stations
                </div>
            </div>
        </div>
        <div class="col-sm-3 col-xs-6 pt-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="title text-center">{{$trainCount}}<br>
                        <a href="{{route('trains.index')}}" class="stat-link">
                            <i class="fa fa-train fa-2x"></i>
                        </a>
                    </h4>
                </div>
                <div class="card-body text-center">
                    Trains
                </div>
            </div>
        </div>
        <div class="col-sm-3 col-xs-6 pt-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="title text-center">{{$idVerificationCount}}<br>
                        <a href="{{route('id_check.oldest')}}" class="stat-link">
                            <i class="fa fa-id-card-o fa-2x"></i>
                        </a>
                    </h4>
                </div>
                <div class="card-body text-center">
                    Awaiting Check
                </div>
            </div>
        </div>

    </div>

@endsection