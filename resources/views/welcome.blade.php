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
                            <img src="{{secure_asset('img/logo-icon.png')}}" class="icon align-top d-inline-block d-sm-none"
                                 alt="logo passe ton billet">
                        </a>
                        <ul class="navbar-nav navbar-expand">
                            <li class="nav-item">
                                <a class="nav-link btn btn-ptb d-none d-sm-block" href="{{route('public.ticket.sell.page')}}">@lang('nav.resell_a_ticket')</a>
                                <a class="nav-link btn btn-ptb d-block d-sm-none" href="{{route('public.ticket.sell.page')}}">@lang('nav.sell_ticket.mobile')</a>
                            </li>
                            @if (Auth::guest())
                                <li class="nav-item">
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
                            <home-search :lang="child.welcome.ticketLang"
                                         :routes="child.welcome.routes"
                                         :api="child.welcome.api"
                            ></home-search>
                        </div>
                    </div>
                </div>
            </div>
            <div class="section-favorites" id="section-favorites">
                <h2 class="text-center text-warning title">{{__('welcome.favorites.title')}}</h2>
                <h5 class="text-center text-warning subtitle">{{__('welcome.favorites.subtitle')}}</h5>


                <div class="d-flex flex-row flex-nowrap cards-horizontal-list">
                    <div class="card card-trip">
                        <div class="card-img-top-background" style="background-image: url('img/cities/london.jpeg')">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Paris <span class="arrow"></span> Londres</h5>
                        </div>
                    </div>
                    <div class="card card-trip">
                        <div class="card-img-top-background" style="background-image: url('img/cities/lyon.jpg')">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Paris <span class="arrow"></span> Lyon</h5>
                            <div class="orange-card-border"></div>
                        </div>
                    </div>
                    <div class="card card-trip">
                        <div class="card-img-top-background" style="background-image: url('img/cities/paris.jpeg')">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Lyon <span class="arrow"></span> Paris</h5>
                        </div>
                    </div>
                    <div class="card card-trip">
                        <div class="card-img-top-background" style="background-image: url('img/cities/marseille.jpg')">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Paris <span class="arrow"></span> Marseille</h5>
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
            </div>

            <div class="section-howitworks"
                 style="background-image: url('{{secure_asset('img/bg/111.jpg')}}'); background-size:cover;">
                <h2 class="text-center text-warning title">{{__('welcome.howitworks.title')}}</h2>
                <div class="selector">
                    <button id="btn-buyer"
                            :class="{'text-uppercase':true,'selected':child.welcome.stateHowItWorks=='buyer'}"
                            @click.prevent="child.welcome.stateHowItWorks='buyer'">
                        {{__('welcome.howitworks.buttons.buyer')}}
                    </button>
                    <button id="btn-seller"
                            :class="{'text-uppercase':true,'selected':child.welcome.stateHowItWorks=='seller'}"
                            @click.prevent="child.welcome.stateHowItWorks='seller'">
                        {{__('welcome.howitworks.buttons.seller')}}
                    </button>
                </div>
                <transition name="el-fade-in">
                    <div class="container" v-if="child.welcome.stateHowItWorks=='buyer'" v-cloak>
                        <div class="row">
                            <div class="col-12 col-md-6 col-lg-3 col-sm-6 mt-3">
                                <img class="svg-icon"
                                     src="{{secure_asset('img/icon_search.svg')}}"
                                     alt="Icon Search"
                                />
                                <h3 class="howitworks-title  pt-1">@lang('welcome.howitworks.search.title')</h3>
                                <p class="howitworks-text">@lang('welcome.howitworks.search.text')</p>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3 col-sm-6 mt-3">
                                <img class="svg-icon"
                                     src="{{secure_asset('img/icon_auction.svg')}}"
                                     alt="Icon Auction"
                                />
                                <h3 class="howitworks-title  pt-1">@lang('welcome.howitworks.auction.title')</h3>
                                <p class="howitworks-text">@lang('welcome.howitworks.auction.text')</p>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3 col-sm-6 mt-3">
                                <img class="svg-icon"
                                     src="{{secure_asset('img/icon_chat.svg')}}"
                                     alt="Icon Chat"
                                />
                                <h3 class="howitworks-title  pt-1">@lang('welcome.howitworks.chat.title')</h3>
                                <p class="howitworks-text">@lang('welcome.howitworks.chat.text')</p>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3 col-sm-6 mt-3">
                                <img class="svg-icon"
                                     src="{{secure_asset('img/icon_send.svg')}}"
                                     alt="Icon Send"
                                />
                                <h3 class="howitworks-title  pt-1">@lang('welcome.howitworks.send.title')</h3>
                                <p class="howitworks-text">@lang('welcome.howitworks.send.text')</p>
                            </div>
                        </div>
                    </div>
                </transition>
                <transition name="el-fade-in">
                    <div class="container" v-if="child.welcome.stateHowItWorks=='seller'" v-cloak>
                        <div class="row">
                            <div class="col-12 col-md-6 col-lg-3 col-sm-6 mt-3">
                                <img class="svg-icon"
                                     src="{{secure_asset('img/icon_sell.svg')}}"
                                     alt="Icon Sell"
                                />
                                <h3 class="howitworks-title  pt-1">@lang('welcome.howitworks.sell.title')</h3>
                                <p class="howitworks-text">@lang('welcome.howitworks.sell.text')</p>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3 col-sm-6 mt-3">
                                <img class="svg-icon"
                                     src="{{secure_asset('img/icon_accept.svg')}}"
                                     alt="Icon Accept"
                                />
                                <h3 class="howitworks-title  pt-1">@lang('welcome.howitworks.accept.title')</h3>
                                <p class="howitworks-text">@lang('welcome.howitworks.accept.text')</p>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3 col-sm-6 mt-3">
                                <img class="svg-icon"
                                     src="{{secure_asset('img/icon_chat2.svg')}}"
                                     alt="Icon Chat"
                                />
                                <h3 class="howitworks-title  pt-1">@lang('welcome.howitworks.chat2.title')</h3>
                                <p class="howitworks-text">@lang('welcome.howitworks.chat2.text')</p>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3 col-sm-6 mt-3">
                                <img class="svg-icon"
                                     src="{{secure_asset('img/icon_send2.svg')}}"
                                     alt="Icon Send"
                                />
                                <h3 class="howitworks-title  pt-1">@lang('welcome.howitworks.send2.title')</h3>
                                <p class="howitworks-text">@lang('welcome.howitworks.send2.text')</p>
                            </div>
                    </div>
                </transition>
            </div>

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

    <script type="application/javascript">

        function checkScroll() {
            let scroll = window.scrollY;

            if(scroll > 200){
                document.getElementById('nav').classList.remove("pos-top");
            }
            else {
                document.getElementById('nav').classList.add("pos-top");
            }
        }

        (function() {
            window.addEventListener('scroll', function(){
                checkScroll();
            });
        })();

        checkScroll();

    </script>


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


