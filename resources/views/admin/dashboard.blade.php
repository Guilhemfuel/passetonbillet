@extends('admin.layouts.app')


@section('title')
    - Home
@endsection

@section('content')

    <div class="col-md-4 col-sm-6 col-xs-12">
        @component('admin.components.card')
            @section('card-title')
                Dashboard
            @endsection
            @section('card-body')
                Welcome on Lastar admin, {{Auth::user()->first_name}} !
            @endsection
        @endcomponent
    </div>

@endsection