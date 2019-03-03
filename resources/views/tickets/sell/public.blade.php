@extends('layouts.app')

@section('advanced_title')
    <title>@lang('tickets.sell.public.title')</title>
@endsection

@section('content')

    <div class="sell-public">
        <div class="section-header">
            <div class="first-section orange-gradient">
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
                                <a class="nav-link btn btn-ptb d-none d-sm-none d-md-block"
                                   href="{{route('tickets.sell')}}"
                                   @click.prevent="logEvent('nav_sell_button',{},$event)"
                                >@lang('nav.resell_a_ticket')</a>
                                <a class="nav-link btn btn-ptb d-block d-sm-block d-md-none"
                                   href="{{route('tickets.sell')}}"
                                   @click.prevent="logEvent('nav_sell_button',{},$event)"
                                >@lang('nav.sell_ticket.mobile')</a>
                            </li>
                            @if (Auth::guest())
                                <dropdown-menu v-cloak>
                                    <div class="nav-item menu-unlogged mr-3">
                                        <i class="fa fa-bars" aria-hidden="true"></i>
                                    </div>
                                </dropdown-menu>

                            @else
                                @include('components.nav-logged')
                            @endif

                        </ul>
                    </nav>


                    <div class="content">
                        <div class="center">
                            <h1 class="catchline text-center">@lang('tickets.sell.public.title')</h1>
                            <h3 class="text-white font-weight-bold text-center">
                                @lang('tickets.sell.public.subtitle')
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="iframe-wrapper orange-gradient">
                <iframe>

                </iframe>
            </div>
            <div class="iframe-wrapper"></div>
            <div class="section-btn">
                <a href="" class="text-uppercase font-weight-bold btn btn-ptb-blue text-center">
                    @lang('nav.resell_a_ticket')
                </a>
            </div>
            <div class="section-title" style="text-align: center;">
                <h1 class="font-weight-bold">
                    Do you have a non-refundable ticket to sell ?
                </h1>
                <h2>
                    Passe ton billet is a web platform specialising in quick, easy, and secure train ticket
                    resales. We currently support the following ticket providers:
                </h2>
            </div>
            <div class="section-list-wrapper" style="text-align: center;">
                <div class="section-list list-left" style="display:inline-block;padding-right: 40px">
                    <ul>
                        <li>Idgtv</li>
                        <li>Ter</li>
                        <li>Tgv</li>
                    </ul>
                </div>
                <div class="section-list list-right" style="display:inline-block;">
                    <ul>
                        <li>Eurostar</li>
                        <li>Prems</li>
                        <li>Thalys</li>
                        <li>Sncf</li>
                    </ul>
                </div>
            </div>

            <div class="section-favorites" id="section-favorites">
                <h2 class="text-center text-warning title">@lang('tickets.sell.public.favorites.title')</h2>
                <h5 class="text-center text-warning subtitle">@lang('tickets.sell.public.favorites.subtitle')</h5>


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
                            <a class="card card-trip" href="{{route('public.ticket.buy.page')}}?departure_station=8267&arrival_station=4916">
                                <div class="card-img-top-background"
                                     style="background-image: url('img/cities/paris-2.jpeg')">
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">Londres <span class="arrow"></span> Paris</h5>
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

            <div class="section-feedback" id="section-feedback">
                <h2 class="text-center text-warning title">{{__('welcome.feedback.title')}}</h2>

                <div class="container-fluid">
                    <div class="row px-5">
                        <div class="px-2 col-12 col-sm-6 col-md-4 mt-4">
                            <div class="card card-review ">
                                <div class="card-body">
                                    <img src="{{secure_asset('img/ninie.jpg')}}" class="picture"
                                         alt="user profile picture"/>

                                    <p class="date">
                                        Aujourd'hui
                                    </p>
                                    <h4 class="first-name">
                                        Eugénie
                                    </h4>
                                    <el-rate
                                            :value="5"
                                            disabled
                                            text-color="#FF9600"
                                    >
                                    </el-rate>
                                    <p class="comment">
                                        ‘A peine inscrite j'ai déjà vendu mon A/R Paris Londres. Super site!!’
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="px-2 col-12 col-sm-6 col-md-4 mt-4">
                            <div class="card card-review">
                                <div class="card-body">
                                    <img src="{{secure_asset('img/balou.jpg')}}" class="picture"
                                         alt="user profile picture"/>

                                    <p class="date">
                                        Aujourd'hui
                                    </p>
                                    <h4 class="first-name">
                                        Balthazar
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
                                    <img src="{{secure_asset('img/kristelle.jpg')}}" class="picture"
                                         alt="user profile picture"/>

                                    <p class="date">
                                        Hier
                                    </p>
                                    <h4 class="first-name">
                                        Kristelle
                                    </h4>
                                    <el-rate
                                            :value="5"
                                            disabled
                                            text-color="#FF9600"
                                    >
                                    </el-rate>
                                    <p class="comment">
                                        ‘Enfin une plateforme sécurisée, bien mieux que les groupes Facebook !’
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="section-recent-tickets">
                <h2 class="text-center text-warning title">@lang('tickets.sell.public.recent')</h2>


                <div class="tickets-horizontal-list">
                    <div id="scroll-left" class="scroll-btn">
                        <i class="fa fa-arrow-left" aria-hidden="true"></i>
                    </div>
                    <div id="scroll-right" class="scroll-btn">
                        <i class="fa fa-arrow-right" aria-hidden="true"></i>
                    </div>

                    <div class="tickets">
                        <div class="d-inline-flex px-3">
                            <ticket v-for="ticket in this.tickets" :ticket="ticket" >

                            </ticket>
                        </div>
                    </div>
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

                // On mobile only 20 pix are enough
                if ( (scroll > 200 && !window.Vue.prototype.$mobile) || (scroll > 20 && window.Vue.prototype.$mobile ) ) {
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

    </script>
@endpush


