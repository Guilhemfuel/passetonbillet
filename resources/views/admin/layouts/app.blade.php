<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Ptb Admin @yield('title')</title>

    <!-- Favicon  -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{secure_asset('img/favicon/apple-touch-icon.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{secure_asset('img/favicon/favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{secure_asset('img/favicon/favicon-16x16.png')}}">
    <link rel="manifest" href="{{secure_asset('img/favicon/site.webmanifest')}}">
    <link rel="mask-icon" href="{{secure_asset('img/favicon/safari-pinned-tab.svg')}}" color="#5bbad5">
    <link rel="shortcut icon" href="{{secure_asset('img/favicon/favicon.ico')}}">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="msapplication-config" content="{{secure_asset('img/favicon/browserconfig.xml')}}">

    <!-- Pusher App if-->
    <meta name="pusher:app_key" content="{{env('PUSHER_APP_KEY')}}"/>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="lang" content="{{ config('app.locale') }}">

    <!-- Styles -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
          integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.css" />

    <link rel="stylesheet" href="{{ mix('/css/admin.css') }}">

    <script>
        window.Laravel = {!! json_encode([
                'csrfToken' => csrf_token(),
            ]) !!};
    </script>
</head>

<body>

    <div class="row m-0" id="app">
            <div class="sidebar  {{App::environment()=='local'?'blue-gradient':'purple-gradient'}}  col-md-3 col-sm-4 p-0">

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
                        @yield('content')
                    </div>
                </div>

                @include('admin.components.footer')

            </div>
        </div>


<!-- Scripts -->
<script src="https://cdn.polyfill.io/v2/polyfill.min.js"></script>
<script src="/js/admin.js"></script>
<script type="application/javascript">
    let data = {};
    let currentPage = {
        name: '{!! Route::currentRouteName()!!}',
        data: {}
    };
</script>
@stack('vue-data')
<script>
    const notifications = new Vue({
        el: '#app',
        name: 'Ptb',
        data: {
            messages: {!! ( session()->has('flash_notification') && session('flash_notification')!==null?json_encode(session('flash_notification')):'[]') !!},
            custom_errors: {!!  ($errors->any()?json_encode($errors->all()):'[]') !!},
            child: null,
            user: {!! isset($jsonUser)?json_encode($jsonUser):(isset($userData)?json_encode($userData):(isset($user)?json_encode($user):'null')) !!},
            currentPage: null
        },
        mounted() {

            // Display Messages
            for (var i = 0; i < this.messages.length; i++) {
                this.$message({
                    message: this.messages[i].message,
                    type: this.messages[i].level=='danger'?'error':this.messages[i].level,
                    showClose: true,
                    duration: this.messages[i].important?0:10000,
                    dangerouslyUseHTMLString: true
                });
            }

            var errorsMessage = '<ul style="margin-bottom: 0px!important;">';
            for (var i = 0; i < this.custom_errors.length; i++) {
                errorsMessage += '<li>' + this.custom_errors[i] + '</li>'
            }
            errorsMessage += '</ul>';

            if ( this.custom_errors.length>0) {
                this.$message({
                    dangerouslyUseHTMLString: true,
                    message: errorsMessage,
                    type: 'error',
                    showClose: true,
                    duration: 0
                });
            }

        },
        created: function() {
            this.child = data;
            this.currentPage = currentPage;
        }
    });
</script>
@stack('scripts')
</body>
</html>
