@extends('admin.layouts.app')

@section('admin-title')
    - Statistics
@endsection

@section('admin-content')

    <div id="unique-admin" class="statistics">
        <div class="card">
            <div class="card-header">
                <h4>Statistics</h4>
            </div>

            <div class="card-body">

                <div class="row">
                    <div class="col-md-3 col-sm-6 col-12">
                        <h5 class="text-center">User Registration</h5>
                        <table class="table table-hover table-striped">
                            <thead>
                            <th>Date</th>
                            <th class="text-right">Count</th>
                            </thead>
                            <tbody>
                            @foreach($dailyUserCount as $day => $count)
                                <tr>
                                    <td>{{$day}}</td>
                                    <td class="text-right">{{$count}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                    </div>

                    <div class="col-md-3 col-sm-6 col-12">
                        <h5 class="text-center">Tickets added</h5>
                        <table class="table table-hover table-striped">
                            <thead>
                            <th>Date</th>
                            <th class="text-right">Count</th>
                            </thead>
                            <tbody>
                            @foreach($dailyTicketCount as $day => $count)
                                <tr>
                                    <td>{{$day}}</td>
                                    <td class="text-right">{{$count}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                    </div>

                    <div class="col-md-3 col-sm-6 col-12">
                        <h5 class="text-center">Tickets Sold</h5>
                        <table class="table table-hover table-striped">
                            <thead>
                            <th>Date</th>
                            <th class="text-right">Count</th>
                            </thead>
                            <tbody>
                            @foreach($dailyTicketSoldCount as $day => $count)
                                <tr>
                                    <td>{{$day}}</td>
                                    <td class="text-right">{{$count}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                    </div>

                    <div class="col-md-3 col-sm-6 col-12">
                        <h5 class="text-center">Offers Sent</h5>
                        <table class="table table-hover table-striped">
                            <thead>
                            <th>Date</th>
                            <th class="text-right">Count</th>
                            </thead>
                            <tbody>
                            @foreach($dailyOfferCount as $day => $count)
                                <tr>
                                    <td>{{$day}}</td>
                                    <td class="text-right">{{$count}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                    </div>

                    <div class="col-md-3 col-sm-6 col-12">
                        <h5 class="text-center">Research Done</h5>
                        <table class="table table-hover table-striped">
                            <thead>
                            <th>Date</th>
                            <th class="text-right">Count</th>
                            </thead>
                            <tbody>
                            @foreach($dailyResearchCount as $day => $count)
                                <tr>
                                    <td>{{$day}}</td>
                                    <td class="text-right">{{$count}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                    </div>

                    <div class="col-md-3 col-sm-6 col-12">
                        <h5 class="text-center">Pdf Download</h5>
                        <table class="table table-hover table-striped">
                            <thead>
                            <th>Date</th>
                            <th class="text-right">Count</th>
                            </thead>
                            <tbody>
                            @foreach($dailyPdfDownloadCount as $day => $count)
                                <tr>
                                    <td>{{$day}}</td>
                                    <td class="text-right">{{$count}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>


            </div>
        </div>
    </div>

@endsection
