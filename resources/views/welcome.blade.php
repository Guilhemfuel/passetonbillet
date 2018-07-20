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
                                <a class="nav-link" href="{{route('login')}}">@lang('nav.login')</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link btn btn-ptb" href="{{route('register')}}">@lang('nav.register')</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" onclick="$crisp.push(['do', 'chat:open'])">
                                    <i class="fa fa-question-circle" aria-hidden="true"></i>
                                </a>
                            </li>
                            @if (App::isLocale('fr'))
                                <a class="nav-link flag" href="{{route('lang','en')}}">
                                    <span class="flag-icon flag-icon-gb"></span>
                                </a>
                            @else
                                <a class="nav-link flag" href="{{route('lang','fr')}}">
                                    <span class="flag-icon flag-icon-fr"></span>
                                </a>
                            @endif
                        </ul>
                    </nav>
                    <div class="content">
                        <div class="center">
                            <img class="main-logo align-top" src="{{secure_asset('img/logo.png')}}"  alt="logo passe ton billet">
                            <h3 class="text-center catchline">@lang('welcome.advantages.one_clic')</h3>
                            <home-search :tickets="child.welcome.tickets"
                                      :state="child.welcome.stateBuySell"
                                      :lang="child.welcome.ticketLang"
                                      :routes="child.welcome.routes"
                                      :api="child.welcome.api"
                                      :stations="child.welcome.stations"
                                      v-on:change-state="child.welcome.stateBuySell=$event"
                            ></home-search>

                            <a href="{{route('register.page')}}" class="btn btn-white text-uppercase my-5" id="btn-register">
                                @lang('auth.register.title')
                            </a>

                            <div class="text-center text-white" >
                                <i id="scroll-to-search" class="fa fa-angle-down fa-3x mx-auto" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="section-advantages" id="section-advantages">
                <div class="container">
                    <div class="row">
                        <div class="col-12 text-center">
                            <h2 class="text-center text-warning">{{__('welcome.advantages.why_use')}}</h2>
                            <img class="main-logo" src="{{secure_asset('img/logo-black.png')}}"  alt="logo black passe ton billet">
                        </div>
                        <div class="col-sm-12 col-md-4 mt-4">
                            <img class="svg-icon"
                                 src="{{secure_asset('img/icon-safe.svg')}}"
                                 alt="Icon Safer"
                            />
                            <h3 class="advantage-title  pt-1">@lang('welcome.advantages.safer.title')</h3>
                            <p class="advantage-text">@lang('welcome.advantages.safer.text')</p>
                        </div>
                        <div class="col-sm-12 col-md-4 mt-4">
                            <img class="svg-icon"
                                 src="{{secure_asset('img/icon-cheaper.svg')}}"
                                 alt="Icon Cheaper"
                            />
                            <h3 class="advantage-title pt-1">@lang('welcome.advantages.cheaper.title')</h3>
                            <p class="advantage-text">@lang('welcome.advantages.cheaper.text')</p>
                        </div>
                        <div class="col-sm-12 col-md-4 mt-4">
                            <img class="svg-icon"
                                 src="{{secure_asset('img/icon-quick.svg')}}"
                                 alt="Icon quicker"
                            />
                            <h3 class="advantage-title pt-1">@lang('welcome.advantages.quicker.title')</h3>
                            <p class="advantage-text">@lang('welcome.advantages.quicker.text')</p>
                        </div>
                        <div class="col-12 text-center">
                            <a href="#" class="btn btn-ptb mt-4 px-5">
                                @lang('welcome.advantages.more_info')
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            @include('components.footer')

        </div>

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
