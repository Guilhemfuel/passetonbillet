@extends('layouts.app')

@section('content')

    <div class="welcome-page">

        <div class="section-header">
            <div class="first-section" style="background-image: url('{{asset('img/bg/5.jpg')}}');">
                <div class="fixed-content">
                    <nav class="navbar">
                        <a class="navbar-brand" href="#">
                            <img src="{{asset('img/logo.png')}}" class="d-inline-block align-top" alt="logo lastar">
                        </a>
                        <ul class="navbar-nav navbar-expand">
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('login')}}">@lang('nav.login')</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('register')}}">@lang('nav.register')</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" onclick="$crisp.push(['do', 'chat:open'])">
                                    <i class="fa fa-question-circle" aria-hidden="true"></i>
                                </a>
                            </li>
                            @if (App::isLocale('fr'))
                                <a class="nav-link" href="{{route('lang','en')}}">
                                    <span class="flag-icon flag-icon-fr"></span>
                                </a>
                            @else
                                <a class="nav-link" href="{{route('lang','fr')}}">
                                    <span class="flag-icon flag-icon-gb"></span>
                                </a>
                            @endif
                        </ul>
                    </nav>
                    <div class="content">
                        <div class="center">
                            <h1 class="text-center text-white">LASTAR</h1>
                            <div class="action-buttons">
                                <button class="btn btn-lastar-blue" id="btn-buy"
                                        @click="stateBuySell='buy'">@lang('common.button.buy')</button>
                                <button class="btn btn-danger" id="btn-sell"
                                        @click="stateBuySell='sell'">@lang('common.button.sell')</button>
                            </div>
                            <div class="tickets mx-auto d-none d-sm-none d-md-block">
                                <div class="first-ticket">
                                    <ticket :ticket="tickets[0]" :lang="ticketLang.component"></ticket>
                                </div>
                                <div class="secund-ticket">
                                    <ticket :ticket="tickets[1]" :lang="ticketLang.component"></ticket>
                                </div>
                                <div class="third-ticket">
                                    <ticket :ticket="tickets[2]" :lang="ticketLang.component"></ticket>
                                </div>
                            </div>
                            <div class="tickets-sm d-none d-sm-flex d-md-none">
                                <div class="first-ticket">
                                    <ticket :ticket="tickets[0]" :lang="ticketLang.component"></ticket>
                                </div>
                                <div class="secund-ticket">
                                    <ticket :ticket="tickets[1]" :lang="ticketLang.component"></ticket>
                                </div>
                            </div>
                            <div class="tickets-xs d-flex d-sm-none">
                                <div class="first-ticket">
                                    <ticket :ticket="tickets[1]" :lang="ticketLang.component"></ticket>
                                </div>
                            </div>
                            <div class="text-center text-white">
                                <i id="scroll-to-search" class="fa fa-angle-down fa-3x mx-auto" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="section-search" id="section-search">
                <div class="container">
                    <div class="row" id="buy-ticket">
                        <buy-sell :stations="stations"
                                  :api="api"
                                  :routes="routes"
                                  :lang="ticketLang"
                                  :csrf="csrf"
                                  :state="stateBuySell"
                                  v-on:change-state="changeState($event)"
                        ></buy-sell>
                    </div>
                </div>
            </div>
            <div class="section-advantages" id="section-advantages">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-sm-4 mt-4">
                            <img class="svg-icon"
                                 src="{{asset('img/icon-quick.svg')}}"
                                 alt="Icon quicker"
                            />
                            <h3 class="advantage-title mt-0">@lang('welcome.advantages.quicker.title')</h3>
                            <p class="advantage-text">@lang('welcome.advantages.quicker.text')</p>
                        </div>
                        <div class="col-12 col-sm-4 mt-4">
                            <img class="svg-icon"
                                 src="{{asset('img/icon-cheaper.svg')}}"
                                 alt="Icon Cheaper"
                            />
                            <h3 class="advantage-title mt-0">@lang('welcome.advantages.cheaper.title')</h3>
                            <p class="advantage-text">@lang('welcome.advantages.cheaper.text')</p>
                        </div>
                        <div class="col-12 col-sm-4 mt-4">
                            <img class="svg-icon"
                                 src="{{asset('img/icon-safe.svg')}}"
                                 alt="Icon Safer"
                            />
                            <h3 class="advantage-title  pt-1">@lang('welcome.advantages.safer.title')</h3>
                            <p class="advantage-text">@lang('welcome.advantages.safer.text')</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="section-footer">
                <div class="container">
                    <p class="text-center text-white pt-4">Lastar ©</p>
                    <div class="footer-content">
                        <div class="text-white">
                            <div class="row">
                                <div class="col-sm-6 col-12">
                                    <a class="text-white" href="#">@lang('welcome.footer.about')</a>
                                </div>
                                <div class="col-sm-6 col-12">
                                    <a class="text-white" href="#" onclick="e.preventDefault();$crisp.push(['do', 'chat:open'])">@lang('welcome.footer.help')</a>
                                </div>
                                <div class="col-sm-6 col-12">
                                    <a href="#" class="text-white" onclick="e.preventDefault();$crisp.push(['do', 'chat:open'])">@lang('welcome.footer.contact')</a>
                                </div>
                                <div class="col-sm-6 col-12">
                                    <a class="text-white" href="#">@lang('welcome.footer.conditions')</a>
                                </div>
                            </div>
                        </div>
                        <div class="text-white">
                            <p>
                                <a href="https://www.facebook.com/Lastar-166045200683624/">
                                    <i class="fa fa-2x fa-facebook text-white" aria-hidden="true"></i>
                                </a>
                                <a href="https://twitter.com/lastarofficial">
                                    <i class="fa fa-2x fa-twitter text-white" aria-hidden="true"></i>
                                </a>
                            </p>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>

        @endsection

        @push('scripts')

            <?php
            $langTickets = Lang::get( 'tickets' );
            $routes = [
                'tickets'  => [

                ],
                'register' => route( 'register.page' )
            ];
            $api = [
                'tickets' => [
                    'buy' => route( 'api.tickets.buy' )
                ]
            ];
            ?>


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
                        scrollTo(document.getElementById("section-search"));
                    });
                    document.getElementById("btn-buy").addEventListener('click', () => {
                        scrollTo(document.getElementById("section-search"));
                    });
                    document.getElementById("btn-sell").addEventListener('click', () => {
                        scrollTo(document.getElementById("section-search"));
                    });
                }

                const app = new Vue({
                    el: '#app',
                    data: {
                        tickets: {!! json_encode($tickets) !!},
                        ticketLang: {!! json_encode($langTickets) !!},
                        csrf: '{!! csrf_token() !!}',
                        routes: {!! json_encode($routes) !!},
                        api: {!! json_encode($api) !!},
                        stations: {!! json_encode($stations) !!},
                        stateBuySell: 'buy'
                    },
                    methods: {
                        changeState($event) {
                            this.stateBuySell = $event;
                        }
                    }
                });
            </script>
    @endpush