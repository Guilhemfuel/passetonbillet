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
                                   href="{{route('public.ticket.sell.page')}}"
                                   @click.prevent="logEvent('nav_sell_button',{},$event)"
                                >@lang('nav.resell_a_ticket')</a>
                                <a class="nav-link btn btn-ptb d-block d-sm-block d-md-none"
                                   href="{{route('public.ticket.sell.page')}}"
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

            <recent-tickets></recent-tickets>

            <div class="section-favorites" id="section-favorites">
                <h2 class="text-center text-warning title">{{__('welcome.favorites.title')}}</h2>
                <h5 class="text-center text-warning subtitle">{{__('welcome.favorites.subtitle')}}</h5>


                <div class="cards-horizontal-list">
                    <div id="scroll-left-cities" class="scroll-btn">
                        <i class="fa fa-arrow-left" aria-hidden="true"></i>
                    </div>
                    <div id="scroll-right-cities" class="scroll-btn">
                        <i class="fa fa-arrow-right" aria-hidden="true"></i>
                    </div>

                    <div class="cards" id="cards-trips">
                        <div class="d-inline-flex px-3">
                            <a class="card card-trip" href="{{route('public.ticket.buy.page')}}?departure_station=4916&arrival_station=8267">
                                <div class="card-img-top-background"
                                     v-lazy:background-image="'{{secure_asset('img/cities/london.jpeg')}}'">
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">Paris <span class="arrow"></span> Londres</h5>
                                </div>
                            </a>
                            <a class="card card-trip" href="{{route('public.ticket.buy.page')}}?departure_station=8267&arrival_station=4916">
                                <div class="card-img-top-background"
                                     v-lazy:background-image="'{{secure_asset('img/cities/paris-2.jpeg')}}'">
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">Londres <span class="arrow"></span> Paris</h5>
                                </div>
                            </a>
                            <a class="card card-trip" href="{{route('public.ticket.buy.page')}}?departure_station=4916&arrival_station=4718">
                                <div class="card-img-top-background"
                                     v-lazy:background-image="'{{secure_asset('img/cities/lyon.jpg')}}'"
                                >
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">Paris <span class="arrow"></span> Lyon</h5>
                                    <div class="orange-card-border"></div>
                                </div>
                            </a>
                            <a class="card card-trip" href="{{route('public.ticket.buy.page')}}?departure_station=4718&arrival_station=4916">
                                <div class="card-img-top-background"
                                     v-lazy:background-image="'{{secure_asset('img/cities/paris.jpeg')}}'"
                                >
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">Lyon <span class="arrow"></span> Paris</h5>
                                </div>
                            </a>
                            <a class="card card-trip" href="{{route('public.ticket.buy.page')}}?departure_station=4916&arrival_station=4791">
                                <div class="card-img-top-background"
                                     v-lazy:background-image="'{{secure_asset('img/cities/marseille.jpg')}}'"
                                >
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
                            <img class="main-logo"
                                 is-lazy="true"
                                 v-lazy="'{{secure_asset('img/logo-black.png')}}'"
                                 alt="logo black passe ton billet">
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-3 mt-3">
                            <img class="svg-icon"
                                 is-lazy="true"
                                 v-lazy="'{{secure_asset('img/icon-safe.svg')}}'"
                                 alt="Icon Safer"
                            />
                            <h3 class="advantage-title  pt-1">@lang('welcome.advantages.safer.title')</h3>
                            <p class="advantage-text">@lang('welcome.advantages.safer.text')</p>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-3 mt-3">
                            <img class="svg-icon"
                                 is-lazy="true"
                                 v-lazy="'{{secure_asset('img/icon-cheaper.svg')}}'"
                                 alt="Icon Cheaper"
                            />
                            <h3 class="advantage-title pt-1">@lang('welcome.advantages.cheaper.title')</h3>
                            <p class="advantage-text">@lang('welcome.advantages.cheaper.text')</p>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-3 mt-3">
                            <img class="svg-icon"
                                 is-lazy="true"
                                 v-lazy="'{{secure_asset('img/icon-quick.svg')}}'"
                                 alt="Icon quicker"
                            />
                            <h3 class="advantage-title pt-1">@lang('welcome.advantages.quicker.title')</h3>
                            <p class="advantage-text">@lang('welcome.advantages.quicker.text')</p>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-3 mt-3">
                            <img class="svg-icon"
                                 is-lazy="true"
                                 v-lazy="'{{secure_asset('img/icon-10years.svg')}}'"
                                 alt="Icon 10 Years"
                            />
                            <h3 class="advantage-title pt-1">@lang('welcome.advantages.10years.title')</h3>
                            <p class="advantage-text">@lang('welcome.advantages.10years.text')</p>
                        </div>
                    </div>
                </div>
            </div>

            <reviews></reviews>

            <home-buyer-seller-info></home-buyer-seller-info>

            <blog-posts></blog-posts>

            <div class="section-FAQ" id="section-FAQ">
                <h2 class="text-center text-warning title FAQ-title">{{__('welcome.FAQ.title')}}</h2>
                @foreach($questions->resolve() as $key=>$question)
                <div>
                    <input type="checkbox" class="read-more-state" id="post-{{$key}}"/>
                    <ul class="read-more-wrap">
                        <label for="post-{{$key}}" class="questions">
                            <li class="question"> {{$question['title']}}</li>
                            <li class="answer">{!! $question['content'] !!}</li>
                        </label>
                    </ul>
                </div>
                @endforeach
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
             *   Script to slide the card-trips and recent-tickets
             */
            let rightTripBtn = document.getElementById('scroll-right-cities');
            let leftTripBtn = document.getElementById('scroll-left-cities');

            let tripContainer = document.getElementById('cards-trips');

            rightTripBtn.onclick = function () {
                sideScroll(tripContainer, 'right', 25, 365, 25);
            };

            leftTripBtn.onclick = function () {
                sideScroll(tripContainer, 'left', 25, 365, 25);
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


@push('vue-data')
    <script type="application/javascript">

        data.welcome = {
            stateHowItWorks: 'buyer'
        },

        currentPage.data.defaultStations = {!! json_encode($defaultStations) !!};
        currentPage.data.departureStation = {!! json_encode($departureStation) !!};
        currentPage.data.arrivalStation = {!! json_encode($arrivalStation) !!};

    </script>
@endpush


