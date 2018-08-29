<nav class="navbar navbar-light navbar-expand" id="nav-bar">
    <div class="container-fluid">
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="navbar-brand p-0" href="{{route('home')}}">
                        <img src="{{secure_asset('img/logo-black.png')}}" class="align-top logo-black"
                             alt="logo passe ton billet">
                        <img src="{{secure_asset('img/logo-icon.png')}}" class="icon align-top d-inline-block d-sm-none"
                             alt="logo passe ton billet">
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                    @if(Route::current()->getName() != 'public.ticket.sell.page')
                        <li class="nav-item">
                            @if(Auth::guest())
                                <a class="nav-link btn btn-ptb d-none d-sm-block"
                                   href="{{route('register.page')}}?source={{\App\Http\Controllers\Auth\RegisterController::SOURCE_GUEST_SELL}}"
                                >@lang('nav.resell_a_ticket')</a>
                                <a class="nav-link btn btn-ptb d-block d-sm-none"
                                   href="{{route('register.page')}}?source={{\App\Http\Controllers\Auth\RegisterController::SOURCE_GUEST_SELL}}"
                                >@lang('nav.sell_ticket.mobile')</a>
                            @else
                                <a class="nav-link btn btn-ptb d-none d-sm-block"
                                   href="{{route('public.ticket.sell.page')}}">@lang('nav.resell_a_ticket')</a>
                                <a class="nav-link btn btn-ptb d-block d-sm-none"
                                   href="{{route('public.ticket.sell.page')}}">@lang('nav.sell_ticket.mobile')</a>
                            @endif
                        </li>
                    @endif
                    @if(Route::current()->getName() != 'public.ticket.buy.page' && Route::current()->getName() != 'home')
                        <li class="nav-item ml-2">
                            <a class="nav-link btn btn-ptb-white d-none d-sm-block mt-0"
                               href="{{route('home')}}">@lang('nav.buy_ticket')</a>
                            <a class="nav-link btn btn-ptb-white d-block d-sm-none mt-0"
                               href="{{route('home')}}">@lang('nav.buy_ticket.mobile')</a>
                        </li>
                    @endif
                @if(Auth::check())
                    @include('components.nav-logged')
                @else
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
                @endif
            </ul>
        </div>
    </div>
</nav>




