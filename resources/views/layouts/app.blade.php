<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport"
          content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, width=device-width"/>

    @section('advanced_title')
        <title>PasseTonBillet @yield('title')</title>
    @show

    <meta name="description"
          content="PasseTonBillet : leader sur l'achat et revente de billet de train entre particulier depuis 10 ans. Le seul site 100% gratuit, sans comissions."/>

    <!-- Favicon  -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{secure_asset('img/favicon/apple-touch-icon.png?v=2')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{secure_asset('img/favicon/favicon-32x32.png?v=2')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{secure_asset('img/favicon/favicon-16x16.png?v=2')}}">
    <link rel="manifest" href="{{secure_asset('img/favicon/site.webmanifest?v=2')}}">
    <link rel="mask-icon" href="{{secure_asset('img/favicon/safari-pinned-tab.svg?v=2')}})" color="#FF9600">
    <link rel="shortcut icon" href="{{secure_asset('img/favicon/favicon.ico?v=2')}}">
    <meta name="msapplication-TileColor" content="#ff9600">
    <meta name="msapplication-config" content="{{secure_asset('img/favicon/browserconfig.xml?v=2')}}">
    <meta name="theme-color" content="#ffffff">

    <!-- Google Property -->
    <meta name="google-site-verification" content="plz3_qbBsOX7Cb8I7FvDpQ9dPNHKhlzDuHDRzsefXbY"/>

    <!-- Facebook MetaTags -->
    <meta property="fb:app_id" content="{{env('FB_APP_ID')}}"/>
    <meta property="og:type" content="website"/>
    <meta property="og:description"
          content="PasseTonBillet : leader sur l'achat et revente de billet de train entre particulier depuis 10 ans. Le seul site 100% gratuit, sans comissions."/>
    @section('advanced_og_title')
        <meta property="og:title" content="Achat & Revente de billets de train d'occasion"/>
    @show
    @section('advanced_og_image')
        <meta property="og:image" content="{{secure_asset('img/preview-fb.jpg')}}"/>
    @show

    <!-- Pusher App id-->
    <meta name="pusher:app_key" content="{{env('PUSHER_APP_KEY')}}"/>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="lang" content="{{ config('app.locale') }}">

    <!-- Styles -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
          integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    @section('main_css_file')
        <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
    @show


    <script>
        window.Laravel = {!! json_encode([
                'csrfToken' => csrf_token(),
            ]) !!};
    </script>
    {{-- Adding Crisp Chat--}}
    <script type="text/javascript">window.$crisp = [];
        window.CRISP_WEBSITE_ID = "243d866a-ba3b-4227-adaf-17c631d4fdb1";
        (function () {
            d = document;
            s = d.createElement("script");
            s.src = "https://client.crisp.chat/l.js";
            s.async = 1;
            d.getElementsByTagName("head")[0].appendChild(s);
        })();</script>

    @yield('head')
</head>

<body>
<div id="app">

    @if(session('login'))
        {{-- Watever that needs to be done on login--}}
    @endif

    @yield('content')

    @stack('modals')

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
<?php echo app( Tightenco\Ziggy\BladeRouteGenerator::class )->generate(); ?>

<script src="/lang/lang-{{ \App::getLocale() }}.js"></script>

@section('main_js_file')
    <script src="{{ mix('/js/app.js')}}"></script>
@show

<script type="application/javascript">
    let data = {};
    let currentPage = {
        name: '{!! Route::currentRouteName()!!}',
        data: {}
    };
    let userData = {!! isset($userData)?json_encode($userData):'null' !!};
</script>
@stack('vue-data')
<script>
    const notifications = new Vue({
        el: '#app',
        name: 'PasseTonBillet',
        data: {
            messages: {!! ( session()->has('flash_notification') && session('flash_notification')!==null?json_encode(session('flash_notification')):'[]') !!},
            custom_errors: {!!  ($errors->any()?json_encode($errors->all()):'[]') !!},
            child: null,
            user: null,
            currentPage: null,
            oldInput: {!! (old() != [] ? json_encode( old() ) : 'null') !!}
        },
        mounted() {

            // Display Messages
            for (var i = 0; i < this.messages.length; i++) {
                this.$message({
                    message: this.messages[i].message,
                    type: this.messages[i].level == 'danger' ? 'error' : this.messages[i].level,
                    showClose: true,
                    duration: this.messages[i].important ? 0 : 10000,
                    dangerouslyUseHTMLString: true
                });
            }

            var errorsMessage = '<ul style="margin-bottom: 0px!important;">';
            for (var i = 0; i < this.custom_errors.length; i++) {
                errorsMessage += '<li>' + this.custom_errors[i] + '</li>'
            }
            errorsMessage += '</ul>';

            if (this.custom_errors.length > 0) {
                this.$message({
                    dangerouslyUseHTMLString: true,
                    message: errorsMessage,
                    type: 'error',
                    showClose: true,
                    duration: 0
                });
            }

        },
        created: function () {
            this.child = data;
            this.currentPage = currentPage;
            this.user = userData;
        }
    });
</script>
@stack('scripts')

@include('cookieConsent::index')


<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-125827385-1"></script>
<script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }

    gtag('js', new Date());

    gtag('config', 'UA-125827385-1');

    @if(Auth::check())
    gtag('set', {'user_id': {{Auth::user()->id}} }); // Set the user ID using signed-in user_id.
    @endif
</script>

</body>
</html>
