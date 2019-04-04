@extends('layouts.app')

@section('advanced_title')
    <title>Acheter et revendre des billets de train pas cher avec PasseTonBillet.fr</title>
@endsection

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
                            <h1 class="catchline text-center">{!! __('welcome.advantages.one_clic') !!}</h1>
                            <home-search></home-search>
                        </div>
                    </div>
                </div>
            </div>
            <div class="section-petition p-5" id="section-petition">
                <h2 class="title text-center">Soutenez la revente de billets de train</h2>
                <h5 class="text-center mb-0">
                    {{--TODO: traduction--}}
                    La SNCF ne délivre plus que des E-billets nominatifs sur les TGV et Intercités. Une pétition a été mise en place pour demander à la SCNF de permettre le changement de nom sur les E-Billets SNCF.<br><br>
                    <a href="https://www.change.org/p/guillaume-p%C3%A9py-sncf-pour-permettre-le-changement-de-nom-des-billets-prem-s-sncf" target="_blank" class="btn btn-white text-center">Signer la pétition</a>
                </h5>
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

                        @foreach ($reviews as $review)
                            <div class="px-2 col-12 col-sm-6 col-md-4 mt-4">
                                <div class="card card-review ">
                                    <div class="card-body">
                                        <img src="{{ $review->user->picture  }}" class="picture"
                                             alt="user profile picture"/>

                                        <p class="date">
                                            {{ $review->date }}
                                        </p>
                                        <h4 class="first-name">
                                            {{ $review->user->first_name }}
                                        </h4>
                                        <el-rate
                                                :value="5"
                                                disabled
                                                text-color="#FF9600"
                                        >
                                        </el-rate>
                                        <p class="comment">
                                            {{ $review->text }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach

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
                            <li class="question"> {{__('faq.questions')[0]['title']}}</li>
                            <li class="answer">{!! __('faq.questions')[0]['content'] !!}</li>
                        </label>
                    </ul>
                </div>
                <div>
                    <input type="checkbox" class="read-more-state" id="post-2"/>
                    <ul class="read-more-wrap">
                        <label for="post-2" class="questions">
                            <li class="question"> {{__('faq.questions')[1]['title']}}</li>
                            <li class="answer">{!! __('faq.questions')[1]['content'] !!}</li>
                        </label>
                    </ul>
                </div>
                <div>
                    <input type="checkbox" class="read-more-state" id="post-3"/>
                    <ul class="read-more-wrap">
                        <label for="post-3" class="questions">
                            <li class="question"> {{__('faq.questions')[2]['title']}}</li>
                            <li class="answer">{!! __('faq.questions')[2]['content'] !!}</li>
                        </label>
                    </ul>
                </div>
                <div>
                    <input type="checkbox" class="read-more-state" id="post-4"/>
                    <ul class="read-more-wrap">
                        <label for="post-4" class="questions">
                            <li class="question"> {{__('faq.questions')[3]['title']}}</li>
                            <li class="answer">{!! __('faq.questions')[3]['content'] !!}</li>
                        </label>
                    </ul>
                </div>
                <div class="button">
                    <a id="btn-seemore" class="btn text-uppercase" href="{{route('help.page')}}">
                        {{__('welcome.FAQ.buttons.seemore')}}
                    </a>
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
        data.welcome = {
            ticketLang: {!! json_encode($langTickets) !!},
            routes: {!! json_encode($routes) !!},
            stateHowItWorks: 'buyer'
        }

        currentPage.data.defaultStations = {!! json_encode($defaultStations) !!}
    </script>
@endpush


