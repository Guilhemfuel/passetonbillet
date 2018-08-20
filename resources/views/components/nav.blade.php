-<nav class="navbar navbar-light navbar-expand" id="nav-bar">
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
                        <a class="nav-link btn btn-ptb d-none d-sm-block btn-sell"
                           href="{{route('public.ticket.sell.page')}}">@lang('nav.resell_a_ticket')</a>
                        <a class="nav-link btn btn-ptb d-block d-sm-none"
                           href="{{route('public.ticket.sell.page')}}">@lang('nav.sell_ticket.mobile')</a>
                    </li>
                @endif
                @if(Route::current()->getName() != 'public.ticket.buy.page')
                    <li class="nav-item ml-2">
                        <a class="nav-link btn btn-ptb-white d-none d-sm-block"
                           href="{{route('public.ticket.buy.page')}}">@lang('nav.buy_ticket')</a>
                        <a class="nav-link btn btn-ptb-white d-block d-sm-none"
                           href="{{route('public.ticket.buy.page')}}">@lang('nav.buy_ticket.mobile')</a>
                    </li>
                @endif
                @include('components.nav-logged')
            </ul>
        </div>
    </div>
</nav>




