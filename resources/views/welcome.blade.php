@extends('layouts.app')

@section('content')

    <div class="welcome-page">
        <div class="section-header">
            <div class="first-section" style="background-image: url('{{secure_asset('img/bg/1.jpg')}}');">
                <div class="fixed-content">
                    <nav class="navbar">
                        <a class="navbar-brand" href="{{route('home')}}">
                            <img src="{{secure_asset('img/logo.png')}}" class="d-inline-block align-top" alt="logo passe ton billet">
                        </a>
                        <ul class="navbar-nav navbar-expand">
                            <li class="nav-item">
                                <a class="nav-link btn btn-ptb" href="#">@lang('nav.resell_a_ticket')</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link btn btn-ptb-white" href="{{route('register')}}">@lang('nav.register')</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link register" href="{{route('login')}}">@lang('nav.login')</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link nav-help" href="#" onclick="$crisp.push(['do', 'chat:open'])">
                                    <i class="fa fa-question-circle" aria-hidden="true"></i>
                                </a>
                            </li>

                        </ul>
                    </nav>
                    <div class="content">
                        <div class="center">
                            <h3 class="catchline">@lang('welcome.advantages.one_clic')</h3>
                            <home-search :tickets="child.welcome.tickets"
                                      :state="child.welcome.stateBuySell"
                                      :lang="child.welcome.ticketLang"
                                      :routes="child.welcome.routes"
                                      :api="child.welcome.api"
                                      :stations="child.welcome.stations"
                                      v-on:change-state="child.welcome.stateBuySell=$event"
                            ></home-search>
                        </div>
                    </div>
                </div>
            </div>
            <div class="section-favorites" id="section-favorites">
                <h2 class="text-center text-warning title">{{__('welcome.favorites.title')}}</h2>
                <h5 class="text-center text-warning subtitle">{{__('welcome.favorites.subtitle')}}</h5>
            </div>

            <div class="section-advantages" id="section-advantages">
                <div class="container">
                    <div class="row">
                        <div class="col-12 text-center">
                            <h2 class="text-center text-warning title">{{__('welcome.advantages.why_use')}}</h2>
                            <img class="main-logo" src="{{secure_asset('img/logo-black.png')}}"  alt="logo black passe ton billet">
                        </div>
                        <div class="col-sm-12 col-md-3 mt-3">
                            <img class="svg-icon"
                                 src="{{secure_asset('img/icon-safe.svg')}}"
                                 alt="Icon Safer"
                            />
                            <h3 class="advantage-title  pt-1">@lang('welcome.advantages.safer.title')</h3>
                            <p class="advantage-text">@lang('welcome.advantages.safer.text')</p>
                        </div>
                        <div class="col-sm-12 col-md-3 mt-3">
                            <img class="svg-icon"
                                 src="{{secure_asset('img/icon-cheaper.svg')}}"
                                 alt="Icon Cheaper"
                            />
                            <h3 class="advantage-title pt-1">@lang('welcome.advantages.cheaper.title')</h3>
                            <p class="advantage-text">@lang('welcome.advantages.cheaper.text')</p>
                        </div>
                        <div class="col-sm-12 col-md-3 mt-3">
                            <img class="svg-icon"
                                 src="{{secure_asset('img/icon-quick.svg')}}"
                                 alt="Icon quicker"
                            />
                            <h3 class="advantage-title pt-1">@lang('welcome.advantages.quicker.title')</h3>
                            <p class="advantage-text">@lang('welcome.advantages.quicker.text')</p>
                        </div>
                        <div class="col-sm-12 col-md-3 mt-3">
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

            <div class="section-howitworks"  style="background-image: url('{{secure_asset('img/bg/111.jpg')}}'); background-size:cover;">
                <h2 class="text-center text-warning title">{{__('welcome.howitworks.title')}}</h2>
            <div class="selector">
            <button id="btn-buyer" class="text-uppercase">
                {{__('welcome.howitworks.buttons.buyer')}}
            </button>
            <button id="btn-seller" class="text-uppercase">
                {{__('welcome.howitworks.buttons.seller')}}
            </button>
            </div>
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12 col-md-3 mt-3">
                            <img class="svg-icon"
                                 src="{{secure_asset('img/icon_search.svg')}}"
                                 alt="Icon Search"
                            />
                            <h3 class="howitworks-title  pt-1">@lang('welcome.howitworks.search.title')</h3>
                            <p class="howitworks-text">@lang('welcome.howitworks.search.text')</p>
                        </div>
                        <div class="col-sm-12 col-md-3 mt-3">
                            <img class="svg-icon"
                                 src="{{secure_asset('img/icon_auction.svg')}}"
                                 alt="Icon Auction"
                            />
                            <h3 class="howitworks-title  pt-1">@lang('welcome.howitworks.auction.title')</h3>
                            <p class="howitworks-text">@lang('welcome.howitworks.auction.text')</p>
                        </div>
                        <div class="col-sm-12 col-md-3 mt-3">
                            <img class="svg-icon"
                                 src="{{secure_asset('img/icon_chat.svg')}}"
                                 alt="Icon Chat"
                            />
                            <h3 class="howitworks-title  pt-1">@lang('welcome.howitworks.chat.title')</h3>
                            <p class="howitworks-text">@lang('welcome.howitworks.chat.text')</p>
                        </div>
                        <div class="col-sm-12 col-md-3 mt-3">
                            <img class="svg-icon"
                                 src="{{secure_asset('img/icon_send.svg')}}"
                                 alt="Icon Send"
                            />
                            <h3 class="howitworks-title  pt-1">@lang('welcome.howitworks.send.title')</h3>
                            <p class="howitworks-text">@lang('welcome.howitworks.send.text')</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="section-FAQ" id="section-FAQ">
                <h2 class="text-center text-warning title FAQ-title">{{__('welcome.FAQ.title')}}</h2>
                <div>
                    <input type="checkbox" class="read-more-state" id="post-1" />
                    <ul class="read-more-wrap">
                        <label for="post-1" class="questions">
                            <li class="question">{{__('welcome.FAQ.Q1')}}</li>
                            <li class="answer">{{__('welcome.FAQ.A1')}}</li>
                        </label>
                    </ul>
                </div>
                <div>
                    <input type="checkbox" class="read-more-state" id="post-2" />
                    <ul class="read-more-wrap">
                        <label for="post-2" class="questions">
                            <li class="question">{{__('welcome.FAQ.Q2')}}</li>
                            <li class="answer">{{__('welcome.FAQ.A2')}}</li>
                        </label>
                    </ul>
                </div>
                <div>
                    <input type="checkbox" class="read-more-state" id="post-3" />
                    <ul class="read-more-wrap">
                        <label for="post-3" class="questions">
                            <li class="question">{{__('welcome.FAQ.Q3')}}</li>
                            <li class="answer">{{__('welcome.FAQ.A3')}}</li>
                        </label>
                    </ul>
                </div>
                <div>
                    <input type="checkbox" class="read-more-state" id="post-4" />
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
                tickets: {!! json_encode($tickets) !!},
                ticketLang: {!! json_encode($langTickets) !!},
                routes: {!! json_encode($routes) !!},
                stateBuySell: 'buy'
            }
        </script>
    @endpush

    @push('scripts')
        <script type="application/javascript">
            function scrollTo(element) {
                window.scroll({
                    behavior: 'smooth',
                    left: 0,
                    top: element.offsetTop
                });
            }

            window.onload = function () {
                document.getElementById("scroll-to-search").addEventListener('click', () => {
                    scrollTo(document.getElementById("section-advantages"));
                });
            }
        </script>
    @endpush
