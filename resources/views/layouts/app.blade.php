<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Lastar @yield('title')</title>

    <!-- Favicon  -->
    <link rel="apple-touch-icon" sizes="57x57" href="{{asset('img/favicon/apple-icon-57x57.png')}}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{asset('img/favicon/apple-icon-60x60.png')}}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{asset('img/favicon/apple-icon-72x72.png')}}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{asset('img/favicon/apple-icon-76x76.png')}}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{asset('img/favicon/apple-icon-114x114.png')}}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{asset('img/favicon/apple-icon-120x120.png')}}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{asset('img/favicon/apple-icon-144x144.png')}}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{asset('img/favicon/apple-icon-152x152.png')}}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{asset('img/favicon/apple-icon-180x180.png')}}">
    <link rel="icon" type="image/png" sizes="192x192"  href="{{asset('img/favicon/android-icon-192x192.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('img/favicon/favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{asset('img/favicon/favicon-96x96.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('img/favicon/favicon-16x16.png')}}">
    <link rel="manifest" href="{{asset('img/favicon/manifest.json')}}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{asset('img/favicon/ms-icon-144x144.png')}}">
    <meta name="theme-color" content="#ffffff">

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
<script src="/js/app.js"></script>
@stack('scripts')

{{--@if (getenv('APP_ENV') === 'local')--}}
    {{--<script id="__bs_script__">//<![CDATA[--}}
        {{--document.write("<script async src='https://HOST:3000/browser-sync/browser-sync-client.js?v=2.18.12'><\/script>".replace("HOST", location.hostname));--}}
        {{--//]]>--}}
    {{--</script>--}}
{{--@endif--}}

</body>
</html>
