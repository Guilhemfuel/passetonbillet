@extends('layouts.app')

@section('content')


    <div id="dashboard" class="row">
        <div class="col bg-light-gray" id="main-content">

            @include('components.nav')

            @yield('dashboard-content')
        </div>
    </div>

@endsection

