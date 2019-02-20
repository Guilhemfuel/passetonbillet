@extends('admin.layouts.app')

@section('admin-title')
    - Statistics
@endsection

@section('admin-content')

    <div class="crud-table" id="crud-table">
        <div class="card">
            <div class="card-header">
                <h4>Warnings</h4>
            </div>

            <div class="card-body">

                <div class="table-responsive table-full-width">

                    @if(count($warnings)>0)

                        <table class="table table-hover table-striped">
                            <thead>
                            <th>Date</th>
                            <th>Issue</th>
                            <th>Details</th>
                            <th>Action</th>
                            </thead>
                            <tbody>
                            @foreach($warnings as $warning)
                                <tr>
                                    <td>{{$warning->created_at}}</td>
                                    <td>{{$warning->action}}</td>
                                    <td>
                                        @if($warning->data!=[])
                                            <pretty-json
                                                    :deep="0"
                                                    :data="{{ json_encode($warning->data) }}"
                                            >
                                            </pretty-json>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{$warning->link}}" target="_blank" class="btn btn-sm btn-primary">Do it</a>
                                        <a href="{{route('warnings.mark_as_done',$warning->id)}}" class="btn btn-sm btn-success">Done</a>
                                    </td>

                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                    @else

                        <div class="content">
                            There is no current warnings!
                        </div>

                    @endif

                </div>


            </div>
        </div>


        <div class="card mt-3">
            <div class="card-header">
                <h4>Past Warnings (50 latest)</h4>
            </div>

            <div class="card-body">

                <div class="table-responsive table-full-width">

                    @if(count($pastWarnings)>0)

                        <table class="table table-hover table-striped">
                            <thead>
                            <th>Date</th>
                            <th>Issue</th>
                            <th>Done At</th>
                            <th>Done by</th>
                            <th>Details</th>
                            <th>Action</th>
                            </thead>
                            <tbody>
                            @foreach($pastWarnings as $warning)
                                <tr>
                                    <td>{{$warning->created_at}}</td>
                                    <td>{{$warning->action}}</td>
                                    <td>{{$warning->done_at}}</td>
                                    <td>{{$warning->doneBy->full_name}}</td>
                                    <td>
                                        @if($warning->data!=[])
                                            <pretty-json
                                                    :deep="0"
                                                    :data="{{ json_encode($warning->data) }}"
                                            >
                                            </pretty-json>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{$warning->link}}" target="_blank" class="btn btn-sm btn-primary">Link</a>
                                    </td>

                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                    @else

                        <div class="content">
                            There is no past warnings to display!
                        </div>

                    @endif

                </div>


            </div>
        </div>
    </div>

@endsection
