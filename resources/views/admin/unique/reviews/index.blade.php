@extends('admin.layouts.app')

@section('admin-title')
    - Statistics
@endsection

@section('admin-content')

    <div class="crud-table" id="crud-table">
        <div class="card">
            <div class="card-header">
                <h4>Reviews</h4>
            </div>

            <p class="ml-3">Average User Mark:  {{$reviews->avg('mark')}}</p>

            <div class="card-body">

                <div class="table-responsive table-full-width">

                @if(count($reviews)>0)

                    <table class="table table-hover table-striped">
                        <thead>
                        <th>Date</th>
                        <th>User</th>
                        <th>Note</th>
                        <th>Content</th>
                        </thead>
                        <tbody>
                        @foreach($reviews as $review)
                            <tr>
                                <td>{{$review->created_at}}</td>
                                <td>
                                    @if($review->user)
                                        <a href="{{route("users.edit",$review->user->id)}}" target="_blank">{{$review->user->full_name}}</a>
                                    @else
                                    -
                                    @endif
                                </td>
                                <td>
                                    {{$review->mark}}
                                </td>
                                <td>
                                    {{$review->text}}
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
