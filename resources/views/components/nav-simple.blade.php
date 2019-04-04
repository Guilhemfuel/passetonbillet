<nav class="navbar navbar-light navbar-expand" id="nav-bar">
    <div class="container">
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="navbar-brand p-0" href="{{route('home')}}">
                        <img src="{{secure_asset('img/logo-white.png')}}" class="align-top logo-black"
                             alt="logo passe ton billet">
                        <img src="{{secure_asset('img/logo-icon.png')}}" class="icon align-top d-inline-block d-sm-none"
                             alt="logo passe ton billet">
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">

                <li class="nav-item ml-2">
                    <a class="nav-link btn btn-ptb-white d-none d-md-block mt-0"
                       href="{{route('login')}}"
                       @click.prevent="logEvent('nav_buy_button',{},$event)"
                    >@lang('nav.login')</a>
                    <a class="nav-link btn btn-ptb-white d-block d-md-none mt-0"
                       href="{{route('login')}}"
                       @click.prevent="logEvent('nav_buy_button',{},$event)"
                    >@lang('nav.login')</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link btn btn-ptb d-none d-sm-block mt-0"
                       href="{{route('public.ticket.buy.page')}}?departure_station=8267&arrival_station=4916"
                       @click.prevent="logEvent('nav_sell_button',{},$event)"
                    >@lang('nav.buy_ticket')</a>
                    <a class="nav-link btn btn-ptb d-block d-sm-none mt-0"
                       href="{{route('public.ticket.buy.page')}}?departure_station=8267&arrival_station=4916"
                       @click.prevent="logEvent('nav_sell_button',{},$event)"
                    >@lang('nav.buy_ticket.mobile')</a>
                </li>


                @if(Auth::check())
                    @include('components.nav-logged')
                @else
                    <dropdown-menu v-cloak>
                        <div class="nav-item mr-3">
                            <i class="fa fa-2x fa-question-circle" aria-hidden="true"></i>
                        </div>
                    </dropdown-menu>
                @endif
            </ul>
        </div>
    </div>
</nav>




