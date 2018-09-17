@extends('layouts.app')

@section('title')
    - Admin @yield('admin-title')
@endsection

@section('main_css_file')
    <link rel="stylesheet" href="{{ mix('/css/admin.css') }}">
@endsection

@section('content')


    <div class="row m-0" id="app">
        <div class="sidebar  {{App::environment()!='production'?'purple-gradient':'orange-gradient'}}  col-md-3 col-sm-4 p-0">

            <div class="navbar mb-3">
                <a href="{{route('admin.home')}}" class="navbar-brand mx-auto">
                    Ptb
                </a>
            </div>

            <div class="side-menu">
                <ul class="nav">
                    @include('admin.components.menu')
                </ul>
            </div>
        </div>

        <div class="main-panel col-sm-8 col-md-9 p-0">

            @include('admin.components.nav')

            <div class="content">
                <div class="container-fluid">
                    @yield('admin-content')
                </div>
            </div>

            @include('admin.components.footer')

        </div>
    </div>

@endsection

@section('main_js_file')
    <script src="/js/admin.js"></script>
@endsection

