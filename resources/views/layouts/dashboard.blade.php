@extends('layouts.app')

@section('content')

    @component('components.nav')
    @endcomponent

    <div id="dashboard">
        @yield('dashboard-content')
    </div>

@endsection