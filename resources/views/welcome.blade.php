@extends('layouts.app')

@section('content')

    <div class="welcome-page">
        <div class="section-header">
            <div class="first-section" style="background-image: url('{{secure_asset('img/bg/1.jpg')}}');">
                <div class="fixed-content">
                    <nav class="navbar pos-top" id="nav">
                        <a class="navbar-brand" href="{{route('home')}}">
                            <img src="{{secure_asset('img/logo.png')}}" class="align-top logo-white"
                                 alt="logo passe ton billet">
                            <img src="{{secure_asset('img/logo-black.png')}}" class="align-top logo-black"
                                 alt="logo passe ton billet">
                            <img src="{{secure_asset('img/logo-icon.png')}}"
                                 class="icon align-top d-inline-block d-sm-none"
                                 alt="logo passe ton billet">
                        </a>
                        <ul class="navbar-nav navbar-expand">
                            <li class="nav-item">
                                @if(Auth::guest())
                                    <a class="nav-link btn btn-ptb d-none d-sm-none d-md-block"
                                       href="{{route('register.page')}}?source={{\App\Http\Controllers\Auth\RegisterController::SOURCE_GUEST_SELL}}"
                                    >@lang('nav.resell_a_ticket')</a>
                                    <a class="nav-link btn btn-ptb d-sm-block d-md-none"
                                       href="{{route('register.page')}}?source={{\App\Http\Controllers\Auth\RegisterController::SOURCE_GUEST_SELL}}"
                                    >@lang('nav.sell_ticket.mobile')</a>
                                @else
                                    <a class="nav-link btn btn-ptb d-none d-sm-none d-md-block"
                                       href="{{route('public.ticket.sell.page')}}">@lang('nav.resell_a_ticket')</a>
                                    <a class="nav-link btn btn-ptb d-block d-sm-block d-md-none"
                                       href="{{route('public.ticket.sell.page')}}">@lang('nav.sell_ticket.mobile')</a>
                                @endif
                            </li>
                            @if (Auth::guest())
                                <li class="nav-item d-none d-sm-none d-md-block">
                                    <a class="nav-link btn btn-ptb-white"
                                       href="{{route('register')}}">@lang('nav.register')</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link register  btn btn-ptb-border"
                                       href="{{route('login')}}">@lang('nav.login')</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link nav-help" href="#" onclick="$crisp.push(['do', 'chat:open'])">
                                        <i class="fa fa-question-circle" aria-hidden="true"></i>
                                    </a>
                                </li>

                            @else
                                @include('components.nav-logged')
                            @endif

                        </ul>
                    </nav>
                    <div class="content">
                        <div class="center">
                            <h3 class="catchline">@lang('welcome.advantages.one_clic')</h3>
                            <home-search></home-search>
                        </div>
                    </div>
                </div>
            </div>
            <div class="section-favorites" id="section-favorites">
                <h2 class="text-center text-warning title">{{__('welcome.favorites.title')}}</h2>
                <h5 class="text-center text-warning subtitle">{{__('welcome.favorites.subtitle')}}</h5>


                <div class="cards-horizontal-list">
                    <div id="scroll-left" class="scroll-btn">
                        <i class="fa fa-arrow-left" aria-hidden="true"></i>
                    </div>
                    <div id="scroll-right" class="scroll-btn">
                        <i class="fa fa-arrow-right" aria-hidden="true"></i>
                    </div>

                    <div class="cards" id="cards-trips">
                        <div class="d-inline-flex px-3">
                            <a class="card card-trip" href="{{route('public.ticket.buy.page')}}?departure_station=4916&arrival_station=8267">
                                <div class="card-img-top-background"
                                     style="background-image: url('img/cities/london.jpeg')">
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">Paris <span class="arrow"></span> Londres</h5>
                                </div>
                            </a>
                            <a class="card card-trip" href="{{route('public.ticket.buy.page')}}?departure_station=4916&arrival_station=4718">
                                <div class="card-img-top-background"
                                     style="background-image: url('img/cities/lyon.jpg')">
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">Paris <span class="arrow"></span> Lyon</h5>
                                    <div class="orange-card-border"></div>
                                </div>
                            </a>
                            <a class="card card-trip" href="{{route('public.ticket.buy.page')}}?departure_station=4718&arrival_station=4916">
                                <div class="card-img-top-background"
                                     style="background-image: url('img/cities/paris.jpeg')">
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">Lyon <span class="arrow"></span> Paris</h5>
                                </div>
                            </a>
                            <a class="card card-trip" href="{{route('public.ticket.buy.page')}}?departure_station=4916&arrival_station=4791">
                                <div class="card-img-top-background"
                                     style="background-image: url('img/cities/marseille.jpg')">
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">Paris <span class="arrow"></span> Marseille</h5>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="section-advantages" id="section-advantages">
                <div class="container">
                    <div class="row">
                        <div class="col-12 text-center">
                            <h2 class="text-center text-warning title">{{__('welcome.advantages.why_use')}}</h2>
                            <img class="main-logo" src="{{secure_asset('img/logo-black.png')}}"
                                 alt="logo black passe ton billet">
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-3 mt-3">
                            <img class="svg-icon"
                                 src="{{secure_asset('img/icon-safe.svg')}}"
                                 alt="Icon Safer"
                            />
                            <h3 class="advantage-title  pt-1">@lang('welcome.advantages.safer.title')</h3>
                            <p class="advantage-text">@lang('welcome.advantages.safer.text')</p>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-3 mt-3">
                            <img class="svg-icon"
                                 src="{{secure_asset('img/icon-cheaper.svg')}}"
                                 alt="Icon Cheaper"
                            />
                            <h3 class="advantage-title pt-1">@lang('welcome.advantages.cheaper.title')</h3>
                            <p class="advantage-text">@lang('welcome.advantages.cheaper.text')</p>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-3 mt-3">
                            <img class="svg-icon"
                                 src="{{secure_asset('img/icon-quick.svg')}}"
                                 alt="Icon quicker"
                            />
                            <h3 class="advantage-title pt-1">@lang('welcome.advantages.quicker.title')</h3>
                            <p class="advantage-text">@lang('welcome.advantages.quicker.text')</p>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-3 mt-3">
                            <img class="svg-icon"
                                 src="{{secure_asset('img/icon-10years.svg')}}"
                                 alt="Icon 10 Years"
                            />
                            <h3 class="advantage-title pt-1">@lang('welcome.advantages.10years.title')</h3>
                            <p class="advantage-text">@lang('welcome.advantages.10years.text')</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="section-feedback" id="section-feedback">
                <h2 class="text-center text-warning title">{{__('welcome.feedback.title')}}</h2>

                <div class="container-fluid">
                    <div class="row px-5">
                        <div class="px-2 col-12 col-sm-6 col-md-4 mt-4">
                            <div class="card card-review ">
                                <div class="card-body">
                                    <img class="picture"
                                         src="https://graph.facebook.com/v3.0/10155459972011994/picture?type=normal"
                                         alt="user profile picture"/>

                                    <p class="date">
                                        Aujourd'hui
                                    </p>
                                    <h4 class="first-name">
                                        Julien
                                    </h4>
                                    <el-rate
                                            :value="5"
                                            disabled
                                            text-color="#FF9600"
                                    >
                                    </el-rate>
                                    <p class="comment">
                                        ‘Tout s’est super bien passé, je réutiliserai le site pour sûr !’
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="px-2 col-12 col-sm-6 col-md-4 mt-4">
                            <div class="card card-review">
                                <div class="card-body">
                                    <img class="picture"
                                         src="https://graph.facebook.com/v3.0/10155459972011994/picture?type=normal"
                                         alt="user profile picture"/>

                                    <p class="date">
                                        Aujourd'hui
                                    </p>
                                    <h4 class="first-name">
                                        Julien
                                    </h4>
                                    <el-rate
                                            :value="5"
                                            disabled
                                            text-color="#FF9600"
                                    >
                                    </el-rate>
                                    <p class="comment">
                                        ‘Tout s’est super bien passé, je réutiliserai le site pour sûr !’
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="px-2 col-12 col-sm-6 col-md-4 mt-4">
                            <div class="card card-review">
                                <div class="card-body">
                                    <img class="picture"
                                         src="https://graph.facebook.com/v3.0/10155459972011994/picture?type=normal"
                                         alt="user profile picture"/>

                                    <p class="date">
                                        Aujourd'hui
                                    </p>
                                    <h4 class="first-name">
                                        Julien
                                    </h4>
                                    <el-rate
                                            :value="5"
                                            disabled
                                            text-color="#FF9600"
                                    >
                                    </el-rate>
                                    <p class="comment">
                                        ‘Tout s’est super bien passé, je réutiliserai le site pour sûr !’
                                    </p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <reviews></reviews>
            </div>

            <home-buyer-seller-info></home-buyer-seller-info>

            <div class="section-FAQ" id="section-FAQ">
                <h2 class="text-center text-warning title FAQ-title">{{__('welcome.FAQ.title')}}</h2>
                <div>
                    <input type="checkbox" class="read-more-state" id="post-1"/>
                    <ul class="read-more-wrap">
                        <label for="post-1" class="questions">
                            <li class="question">{{__('welcome.FAQ.Q1')}}</li>
                            <li class="answer">{{__('welcome.FAQ.A1')}}</li>
                        </label>
                    </ul>
                </div>
                <div>
                    <input type="checkbox" class="read-more-state" id="post-2"/>
                    <ul class="read-more-wrap">
                        <label for="post-2" class="questions">
                            <li class="question">{{__('welcome.FAQ.Q2')}}</li>
                            <li class="answer">{{__('welcome.FAQ.A2')}}</li>
                        </label>
                    </ul>
                </div>
                <div>
                    <input type="checkbox" class="read-more-state" id="post-3"/>
                    <ul class="read-more-wrap">
                        <label for="post-3" class="questions">
                            <li class="question">{{__('welcome.FAQ.Q3')}}</li>
                            <li class="answer">{{__('welcome.FAQ.A3')}}</li>
                        </label>
                    </ul>
                </div>
                <div>
                    <input type="checkbox" class="read-more-state" id="post-4"/>
                    <ul class="read-more-wrap">
                        <label for="post-4" class="questions">
                            <li class="question">{{__('welcome.FAQ.Q4')}}</li>
                            <li class="answer">{{__('welcome.FAQ.A4')}}</li>
                        </label>
                    </ul>
                </div>
                <div class="button">
                    <button id="btn-seemore" class="text-uppercase">
                        {{__('welcome.FAQ.buttons.seemore')}}
                    </button>
                </div>
            </div>
            <div>
                @include('components.footer')

            </div>

        </div>
    </div>

    @push('scripts')

        <script type="application/javascript">

            /**
             *   Script to toggle to pos-top class of the nav-bar
             */
            function checkScroll() {
                let scroll = window.scrollY;

                if (scroll > 200) {
                    document.getElementById('nav').classList.remove("pos-top");
                }
                else {
                    document.getElementById('nav').classList.add("pos-top");
                }
            }

            (function () {
                window.addEventListener('scroll', function () {
                    checkScroll();
                });
            })();

            // On page load check position of nav
            checkScroll();

        </script>

        <script type="application/javascript">

            /**
             *   Script to slide the card-trip
             */
            let rightBtn = document.getElementById('scroll-right');
            let leftBtn = document.getElementById('scroll-left');

            rightBtn.onclick = function () {
                var container = document.getElementById('cards-trips');
                sideScroll(container, 'right', 25, 365, 25);
            };

            leftBtn.onclick = function () {
                var container = document.getElementById('cards-trips');
                sideScroll(container, 'left', 25, 365, 25);
            };

            function sideScroll(element, direction, speed, distance, step) {
                scrollAmount = 0;
                var slideTimer = setInterval(function () {
                    if (direction == 'left') {
                        element.scrollLeft -= step;
                    } else {
                        element.scrollLeft += step;
                    }
                    scrollAmount += step;
                    if (scrollAmount >= distance) {
                        window.clearInterval(slideTimer);
                    }
                }, speed);
            }


        </script>

    @endpush


@endsection

<?php
$langTickets = Lang::get( 'tickets' );
$routes = [
    'tickets'  => [

    ],
    'register' => route( 'register.page' )
];
?>

@push('vue-data')
    <script type="application/javascript">
        data.welcome = {
            ticketLang: {!! json_encode($langTickets) !!},
            routes: {!! json_encode($routes) !!},
            stateHowItWorks: 'buyer'
        }
    </script>
@endpush


