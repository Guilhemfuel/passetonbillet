<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Lastar @yield('title')</title>

    <!-- Favicon  -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{secure_asset('img/favicon/apple-touch-icon.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{secure_asset('img/favicon/favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{secure_asset('img/favicon/favicon-16x16.png')}}">
    <link rel="manifest" href="{{secure_asset('img/favicon/site.webmanifest')}}">
    <link rel="mask-icon" href="{{secure_asset('img/favicon/safari-pinned-tab.svg')}}" color="#5bbad5">
    <link rel="shortcut icon" href="{{secure_asset('img/favicon/favicon.ico')}}">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="msapplication-config" content="{{secure_asset('img/favicon/browserconfig.xml')}}">
    <meta name="theme-color" content="#ffffff">

    <!-- Facebook MetaTags -->
    <meta property="fb:app_id" content="{{env('FB_APP_ID')}}"/>

    <!-- Pusher App if-->
    <meta name="pusher:app_key" content="{{env('PUSHER_APP_KEY')}}"/>


    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="lang" content="{{ config('app.locale') }}">

    <!-- Styles -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
          integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
    <script>
        window.Laravel = {!! json_encode([
                'csrfToken' => csrf_token(),
            ]) !!};
    </script>
    {{-- Adding Crisp Chat--}}
    <script type="text/javascript">window.$crisp=[];window.CRISP_WEBSITE_ID="16ad47a5-b681-444a-93bf-901198e51212";(function(){d=document;s=d.createElement("script");s.src="https://client.crisp.chat/l.js";s.async=1;d.getElementsByTagName("head")[0].appendChild(s);})();</script>
</head>

<body>
<div id="app">

    @if(session('login'))
        {{-- Watever that needs to be done on login--}}
    @endif

    @yield('content')

</div>

@if(Auth::user())
<script type="application/javascript">
    {{-- If user is connected, pass information to crisp --}}
    $crisp.push(["set", "user:email", "{{Auth::user()->email}}"])
    $crisp.push(["set", "user:nickname", "{{Auth::user()->full_name}}"])
    $crisp.push(["set", "user:avatar", "{{Auth::user()->picture}}"])


</script>
@endif

<!-- Scripts -->
<script src="https://cdn.polyfill.io/v2/polyfill.min.js"></script>
<script src="/js/app.js"></script>
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
        name: 'Lastar',
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
