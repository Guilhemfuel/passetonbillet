@extends('admin.layouts.app')

@section('admin-title')
    - Statistics
@endsection

@section('admin-content')

    <div class="crud-table" id="crud-table">
        <div class="card">
            <div class="card-header">
                <h4>Logs</h4>
            </div>

            <div class="card-body">

                <div class="table-responsive table-full-width">

                @if(count($logs)>0)

                    <table class="table table-hover table-striped">
                        <thead>
                        <th>Date</th>
                        <th>User</th>
                        <th>Action</th>
                        <th>Details</th>
                        </thead>
                        <tbody>
                        @foreach($logs as $log)
                            <tr>
                                <td>{{$log->created_at}}</td>
                                <td>
                                    @if($log->user)
                                        <a href="{{route("users.edit",$log->user->id)}}" target="_blank">{{$log->user->full_name}}</a>
                                    @else
                                    -
                                    @endif
                                </td>
                                <td>{{$log->action}}</td>
                                <td>
                                    <pretty-json
                                            :deep="0"
                                            :data="JSON.parse({{ json_encode($log->data) }})"
                                            >
                                    </pretty-json>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                @else

                    <div class="content">
                        0 entity found!
                    </div>

                @endif

                </div>


            </div>
        </div>
    </div>

@endsection
