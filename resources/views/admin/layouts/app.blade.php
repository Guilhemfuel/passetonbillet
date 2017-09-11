<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Lastar Admin @yield('title')</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Styles -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
          integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="{{ mix('/css/admin.css') }}">

    <script>
        window.Laravel = {!! json_encode([
                'csrfToken' => csrf_token(),
            ]) !!};
    </script>
</head>

<body>

    <div class="row m-0" id="app">
            <div class="sidebar col-md-3 col-sm-4 p-0">

                <div class="navbar mb-3">
                    <a href="{{route('admin.home')}}" class="navbar-brand mx-auto">
                        Lastar
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
                        <div class="row">
                            <div class="col-md-12">
                                @if ($errors->any())
                                    <div class="alert alert-danger alert-dismissible" role="alert">
                                        <button type="button" aria-hidden="true" class="close" data-dismiss="alert" aria-label="Close">×</button>
                                        Whoops!</br>
                                        @foreach ($errors->all() as $error)
                                            <span>{{$error}}</span>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-12">
                                @if (Session::has('success'))
                                    <div class="alert alert-success alert-dismissible" role="alert">
                                        <button type="button" aria-hidden="true" class="close" data-dismiss="alert" aria-label="Close">×</button>
                                        {{ Session::get('success') }}
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-12">
                                @if (Session::has('danger'))
                                    <div class="alert alert-danger alert-dismissible" role="alert">
                                        <button type="button" aria-hidden="true" class="close" data-dismiss="alert" aria-label="Close">×</button>
                                        {{ Session::get('danger') }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        @yield('content')
                    </div>
                </div>

                @include('admin.components.footer')

            </div>
        </div>


<!-- Scripts -->
<script src="/js/admin.js"></script>
@if(Session::has('eurostar_error'))
    <script type="text/javascript">
        $(document).ready(function () {
            swal({
                title: 'Error!',
                text: "{!! Session::get('eurostar_error') !!}",
                type: 'error',
                confirmButtonClass: 'btn btn-primary'
            });
        });
    </script>
@endif
@stack('scripts')
</body>
</html>
