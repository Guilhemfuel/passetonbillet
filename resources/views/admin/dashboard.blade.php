@extends('admin.layouts.app')


@section('title')
    - Home
@endsection

@section('content')

    <div class="col-sm-3 col-xs-6">
        <div class="card ">
            <div class="header">
                <h4 class="title text-center">{{$userCount}}<br><i class="fa fa-user-circle-o"></i></h4>
            </div>
            <div class="content text-center">
                Users
            </div>
        </div>
    </div>
    <div class="col-sm-3 col-xs-6">
        <div class="card ">
            <div class="header">
                <h4 class="title text-center">{{$stationCount}}<br><i class="fa fa-globe"></i></h4>
            </div>
            <div class="content text-center">
                Stations
            </div>
        </div>
    </div>
    <div class="col-sm-3 col-xs-6">
        <div class="card ">
            <div class="header">
                <h4 class="title text-center">{{$trainCount}}<br><i class="fa fa-train"></i></h4>
            </div>
            <div class="content text-center">
                Trains
            </div>
        </div>
    </div>
    <div class="col-sm-3 col-xs-6">
        <div class="card ">
            <div class="header">
                <h4 class="title text-center">{{$ticketCount}}<br><i class="fa fa-ticket"></i></h4>
            </div>
            <div class="content text-center">
                Tickets
            </div>
        </div>
    </div>

@endsection