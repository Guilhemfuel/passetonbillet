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

    @section('advanced_description')
    <meta name="description"
          content="PasseTonBillet : Leader sur l'achat et la revente de billets de train entre particuliers depuis 10 ans. Le seul site 100% gratuit, sans commissions."/>
    @show
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
    <meta name="google-site-verification" content="Gltyd7fyRExsh2Bv0myMl7RJlg2BPcnf72pwex4S3GE"/>

    <!-- Facebook MetaTags -->
    <meta property="fb:app_id" content="{{env('FB_APP_ID')}}"/>
    <meta property="og:type" content="website"/>
    <meta property="og:url" content="{{url()->full()}}"/>
    <meta property="og:description"
          content="Leader sur l'achat et la revente de billets de train entre particuliers depuis 10 ans. Le seul site 100% gratuit, sans commissions."/>
    @section('advanced_og_title')
        <meta property="og:title" content="Achat & Revente de billets de train d'occasion"/>
    @show
    @section('advanced_og_image')
        <meta property="og:image" content="{{secure_asset('img/preview-fb.jpg')}}"/>
    @show
    <meta property="og:image:width" content="1200"/>
    <meta property="og:image:height" content="630"/>

    <!-- Pusher App id-->
    <meta name="pusher:app_key" content="{{env('PUSHER_APP_KEY')}}"/>
    <meta name="google:site_key" content="{{env('NOCAPTCHA_SITEKEY')}}"/>


    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="lang" content="{{ config('app.locale') }}">

    <!-- Styles -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
          integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Assistant:300,400,500,600,700" rel="stylesheet">
    <link crossorigin="anonymous"
          href="{{secure_asset('fonts/vendor/element-ui/packages/theme-chalk/src/element-icons.woff?2fad952a20fbbcfd1bf2ebb210dccf7a')}}"
          as="font" rel=preload>
    @section('main_css_file')
        <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
    @show


    <script>
        window.Laravel = {!! json_encode([
                'csrfToken' => csrf_token(),
            ]) !!};
    </script>
    {{-- Adding Crisp Chat--}}
    <script type="text/javascript">
        window.$crisp = [];
        window.CRISP_WEBSITE_ID = "243d866a-ba3b-4227-adaf-17c631d4fdb1";
        CRISP_RUNTIME_CONFIG = {
            locale: "{{ \App::getLocale() }}"
        };
        (function () {
            d = document;
            s = d.createElement("script");
            s.src = "https://client.crisp.chat/l.js";
            s.async = 1;
            d.getElementsByTagName("head")[0].appendChild(s);
        })();
        $crisp.push(['do', 'chat:hide']);
    </script>

    <script type="text/javascript">
        {{-- Amplitude Analytics --}}
        (function (e, t) {
            var n = e.amplitude || {_q: [], _iq: {}};
            var r = t.createElement("script")
            ;r.type = "text/javascript";
            r.async = true
            ;r.src = "https://cdn.amplitude.com/libs/amplitude-4.4.0-min.gz.js"
            ;r.onload = function () {
                if (e.amplitude.runQueuedFunctions) {
                    e.amplitude.runQueuedFunctions()
                } else {
                    console.log("[Amplitude] Error: could not load SDK")
                }
            }
            ;var i = t.getElementsByTagName("script")[0];
            i.parentNode.insertBefore(r, i)
            ;

            function s(e, t) {
                e.prototype[t] = function () {
                    this._q.push([t].concat(Array.prototype.slice.call(arguments, 0)));
                    return this
                }
            }

            var o = function () {
                    this._q = [];
                    return this
                }
            ;var a = ["add", "append", "clearAll", "prepend", "set", "setOnce", "unset"]
            ;
            for (var u = 0; u < a.length; u++) {
                s(o, a[u])
            }
            n.Identify = o;
            var c = function () {
                    this._q = []
                    ;
                    return this
                }
            ;var l = ["setProductId", "setQuantity", "setPrice", "setRevenueType", "setEventProperties"]
            ;
            for (var p = 0; p < l.length; p++) {
                s(c, l[p])
            }
            n.Revenue = c
            ;var d = ["init", "logEvent", "logRevenue", "setUserId", "setUserProperties", "setOptOut", "setVersionName", "setDomain", "setDeviceId", "setGlobalUserProperties", "identify", "clearUserProperties", "setGroup", "logRevenueV2", "regenerateDeviceId", "logEventWithTimestamp", "logEventWithGroups", "setSessionId", "resetSessionId"]
            ;

            function v(e) {
                function t(t) {
                    e[t] = function () {
                        e._q.push([t].concat(Array.prototype.slice.call(arguments, 0)))
                    }
                }

                for (var n = 0; n < d.length; n++) {
                    t(d[n])
                }
            }

            v(n);
            n.getInstance = function (e) {
                e = (!e || e.length === 0 ? "$default_instance" : e).toLowerCase()
                ;
                if (!n._iq.hasOwnProperty(e)) {
                    n._iq[e] = {_q: []};
                    v(n._iq[e])
                }
                return n._iq[e]
            }
            ;e.amplitude = n
        })(window, document);

        amplitude.getInstance().init("{{env('AMPLITUDE_APP_KEY')}}", null, {
            saveEvents: true,
            includeUtm: true,
            includeReferrer: true,
        });
        window.amplitude = amplitude;
    </script>

    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({
            google_ad_client: "ca-pub-3424683534484480",
            enable_page_level_ads: true
        });
    </script>

    @yield('head')
</head>

<body>


<div id="fb-root"></div>
<script>
    {{-- Facebook --}}
        window.fbAsyncInit = function () {
        FB.init({
            appId: '2544208985804652',
            cookie: true,
            xfbml: true,
            version: 'v3.1'
        });

        FB.AppEvents.logPageView();

    };
</script>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v3.3&appId=253093131783325&autoLogAppEvents=1"></script>

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
        $crisp.push(["set", "user:nickname", "{{Auth::user()->first_name.' '.Auth::user()->last_name}}"])
        $crisp.push(["set", "user:avatar", "{{Auth::user()->picture}}"])

        {{-- Set user ID --}}
        amplitude.getInstance().setUserId({{Auth::id()}});
        {{-- Give additional info --}}
        var identify = new amplitude.Identify().setOnce('email', '{{Auth::user()->email}}').setOnce('created_at', '{{Auth::user()->created_at->toIso8601String()}}');
        amplitude.getInstance().identify(identify);

    </script>
@endif


<!-- Scripts -->
<?php echo app( Tightenco\Ziggy\BladeRouteGenerator::class )->generate(); ?>


<script src="{{ mix('/js/manifest.js')}}"></script>
<script src="{{ mix('/js/vendor.js')}}"></script>
<script src="{{ mix('/js/lang/lang-'.\App::getLocale().'.js')}}"></script>
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
            oldInput: {!! (old() != [] ? json_encode( old() ) : 'null') !!},
            amplitudeEventTypes: {!! json_encode(\App\Helper\Amplitude::EVENTS) !!},
            amplitudeEvents: {!! json_encode(\App\Facades\Amplitude::getEvents()) !!}
        },
        methods: {
            openCrisp(e) {
                window.$crisp.push(['do', 'chat:show']);
                window.$crisp.push(['do', 'chat:open']);
            },
            closeCrisp(e) {
                window.$crisp.push(['do', 'chat:hide']);
            },
            /**
             * Log events to amplitude analytics.
             * Only registered events are allowed. If event variable is set, it automatically follows link it
             * (before click event was prevented).
             *
             * @param eventName
             * @param properties
             * @param event
             */
            logEvent: function (eventName, properties={}, event=null) {
                // Check if event exists
                if (!this.amplitudeEventTypes.includes(eventName)) {
                    throw eventName + " is not a registered amplitude events.";
                }

                // Log event
                window.amplitude.getInstance().logEvent(eventName, properties);

                // If event is specified, and element is link, follow link after tracking is done
                if (event && event.target.tagName.toLowerCase() == 'a') {
                    let location = event.target.getAttribute("href");
                    if (location) {
                        window.location = location;
                    }
                }

            }
    },
    mounted: function () {

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

        // Log events in session
        for (let index in this.amplitudeEvents) {

            let event = this.amplitudeEvents[index];
            // Add user id to amplitude, if needed
            if (event.user) {
                window.amplitude.getInstance().setUserId(event.user.id);
            }

            this.logEvent(event.event,event.data);
        }

    }
    ,
    created: function () {
        this.child = data;
        this.currentPage = currentPage;
        this.user = userData;
    }
    })
    ;
</script>
@stack('scripts')

@include('cookieConsent::index')


<!-- Google Analytics -->
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
