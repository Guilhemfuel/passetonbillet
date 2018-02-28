@extends('layouts.app')

@section('content')

    <div class="welcome-page">

        <div class="section-header">
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
                <h1 class="text-center text-white">LASTAR</h1>
                <div class="action-buttons">
                    <button class="btn btn-lastar-blue" id="btn-buy" @click="stateBuySell='buy'">@lang('common.button.buy')</button>
                    <button class="btn btn-danger" id="btn-sell" @click="stateBuySell='sell'">@lang('common.button.sell')</button>
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
                    <div class="col-xs-12 col-md-4">
                        <img     class="svg-icon"
                                src="{{asset('img/icon-quick.svg')}}"
                                alt="Icon quicker"
                                />
                        <h3 class="advantage-title">@lang('welcome.advantages.quicker.title')</h3>
                        <p class="advantage-text">@lang('welcome.advantages.quicker.text')</p>
                    </div>
                    <div class="col-xs-12 col-md-4">
                        <img     class="svg-icon"
                                src="{{asset('img/icon-cheaper.svg')}}"
                                alt="Icon Cheaper"
                        />
                        <h3 class="advantage-title">@lang('welcome.advantages.cheaper.title')</h3>
                        <p class="advantage-text">@lang('welcome.advantages.cheaper.text')</p>
                    </div>
                    <div class="col-xs-12 col-md-4">
                        <img    class="svg-icon"
                                src="{{asset('img/icon-safe.svg')}}"
                                alt="Icon Safer"
                        />
                        <h3 class="advantage-title">@lang('welcome.advantages.safer.title')</h3>
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
                        <ul>
                            <li>
                                <a>@lang('welcome.footer.about')</a>
                            </li>
                            <li>
                                <a onclick="$crisp.push(['do', 'chat:open'])">@lang('welcome.footer.help')</a>
                            </li>
                            <li>
                                <a onclick="$crisp.push(['do', 'chat:open'])">@lang('welcome.footer.contact')</a>
                            </li>
                            <li>
                                <a>@lang('welcome.footer.conditions')</a>
                            </li>
                        </ul>
                    </div>
                    <div class="text-white">
                        <p>
                            <i class="fa fa-facebook" aria-hidden="true"></i>
                            <i class="fa fa-twitter" aria-hidden="true"></i>
                            <i class="fa fa-instagram" aria-hidden="true"></i>
                        </p>
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
        'tickets' => [

        ],
        'register' => route('register.page')
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
                changeState($event){
                    this.stateBuySell = $event;
                }
            }
        });
    </script>
@endpush