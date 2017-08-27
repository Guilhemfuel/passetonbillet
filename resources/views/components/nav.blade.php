
    <nav id="nav" class="navbar navbar-default">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button id="toggle-nav" type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#collapse-nav" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{route('home')}}">{{config('app.name')}}</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="collapse-nav">
                <ul class="nav navbar-nav navbar-right">
                    @if(!Auth::check())
                        <li>
                            <a class="nav-link" href="{{route('login.page')}}">@lang('nav.login')</a>
                        </li>
                        <li>
                            <a class="nav-link" href="{{route('register.page')}}">@lang('nav.register')</a>
                        </li>
                    @else
                        @if(Auth::user()->isAdmin())
                            <li>
                                <a class="nav-link" href="{{route('admin.home')}}">Admin</a>
                            </li>
                        @endif

                        <li>
                            <a class="nav-link" href="{{route('logout')}}">@lang('nav.logout')</a>
                        </li>
                    @endif
                    <li>
                        <a class="nav-link" href="{{route('test.billet')}}">test</a>
                    </li>
                    <li>
                        @if (App::isLocale('fr'))
                            <a class="nav-link"href="{{route('lang','en')}}">
                                <svg class="flag flag"  viewBox="0 0 36 35" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <defs></defs>
                                    <g id="Flag-FR" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <g id="Layer_1">
                                            <circle id="Oval" fill="#F0F0F0" cx="17.5" cy="17.5" r="17.5"></circle>
                                            <path d="M35,17.5 C35,9.97561523 30.2509375,3.56111328 23.5869238,1.08848633 L23.5869238,33.911582 C30.2509375,31.4388867 35,25.0243848 35,17.5 Z" id="Shape" fill="#F45E58"></path>
                                            <path d="M0,17.5 C0,25.0243848 4.74913086,31.4388867 11.4130762,33.9115137 L11.4130762,1.08848633 C4.74913086,3.56111328 0,9.97561523 0,17.5 Z" id="Shape" fill="#1D7AA2"></path>
                                        </g>
                                    </g>
                                </svg>
                            </a>
                        @else
                            <a class="nav-link" href="{{route('lang','fr')}}">
                                <svg class="flag flag" viewBox="1383 20 35 35" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <!-- Generator: Sketch 41 (35326) - http://www.bohemiancoding.com/sketch -->
                                    <desc>Created with Sketch.</desc>
                                    <defs></defs>
                                    <g id="Flag-UK" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" transform="translate(1383.000000, 20.000000)">
                                        <g id="Layer_1">
                                            <circle id="Oval" fill="#F0F0F0" cx="17.5" cy="17.5" r="17.5"></circle>
                                            <g id="Group" transform="translate(0.546875, 0.546875)" fill="#1D7AA2">
                                                <path d="M3.07070312,6.29876953 C1.69606445,8.08725586 0.65953125,10.1486328 0.0559863281,12.3880176 L9.15995117,12.3880176 L3.07070312,6.29876953 Z" id="Shape"></path>
                                                <path d="M33.8502637,12.3880176 C33.2467188,10.1487012 32.2101172,8.08732422 30.8355469,6.29883789 L24.7464355,12.3880176 L33.8502637,12.3880176 Z" id="Shape"></path>
                                                <path d="M0.0559863281,21.5184375 C0.659599609,23.7577539 1.69613281,25.8191309 3.07070312,27.6075488 L9.15974609,21.5184375 L0.0559863281,21.5184375 L0.0559863281,21.5184375 Z" id="Shape"></path>
                                                <path d="M27.6074805,3.07077148 C25.8189941,1.69613281 23.7576855,0.659599609 21.5183008,0.0559863281 L21.5183008,9.15988281 L27.6074805,3.07077148 Z" id="Shape"></path>
                                                <path d="M6.29876953,30.8354785 C8.08725586,32.2101172 10.1486328,33.2466504 12.3879492,33.8502637 L12.3879492,24.7464355 L6.29876953,30.8354785 Z" id="Shape"></path>
                                                <path d="M12.3878809,0.0559863281 C10.1485645,0.659599609 8.0871875,1.69613281 6.29876953,3.07070313 L12.3878809,9.15981445 L12.3878809,0.0559863281 Z" id="Shape"></path>
                                                <path d="M21.5183691,33.8502637 C23.7576855,33.2466504 25.8190625,32.2101172 27.6074805,30.8355469 L21.5183691,24.7464355 L21.5183691,33.8502637 Z" id="Shape"></path>
                                                <path d="M24.7464355,21.5184375 L30.8355469,27.6076172 C32.2101172,25.8191992 33.2467188,23.7577539 33.8502637,21.5184375 L24.7464355,21.5184375 Z" id="Shape"></path>
                                            </g>
                                            <g id="Group" fill="#F45E58">
                                                <path d="M34.8518652,15.2174121 L19.7827246,15.2174121 L19.7826563,15.2174121 L19.7826563,0.148134766 C19.0354199,0.050859375 18.273623,0 17.5,0 C16.7262402,0 15.9645801,0.050859375 15.2174121,0.148134766 L15.2174121,15.2172754 L15.2174121,15.2173437 L0.148134766,15.2173437 C0.050859375,15.9645801 0,16.726377 0,17.5 C0,18.2737598 0.050859375,19.0354199 0.148134766,19.7825879 L15.2172754,19.7825879 L15.2173437,19.7825879 L15.2173437,34.8518652 C15.9645801,34.9491406 16.7262402,35 17.5,35 C18.273623,35 19.0354199,34.949209 19.7825879,34.8518652 L19.7825879,19.7827246 L19.7825879,19.7826563 L34.8518652,19.7826563 C34.9491406,19.0354199 35,18.2737598 35,17.5 C35,16.726377 34.9491406,15.9645801 34.8518652,15.2174121 Z" id="Shape"></path>
                                                <path d="M22.0652441,22.0653125 L22.0652441,22.0653125 L29.8743457,29.8744141 C30.2335059,29.5153906 30.576123,29.1400293 30.9030176,28.7509277 L24.217334,22.0652441 L22.0652441,22.0652441 L22.0652441,22.0653125 Z" id="Shape"></path>
                                                <path d="M12.9347559,22.0653125 L12.9346191,22.0653125 L5.12558594,29.8743457 C5.48460938,30.2335059 5.8599707,30.576123 6.24907227,30.9030176 L12.9347559,24.2171973 L12.9347559,22.0653125 Z" id="Shape"></path>
                                                <path d="M12.9347559,12.9348926 L12.9347559,12.9347559 L5.1256543,5.12558594 C4.76649414,5.48460938 4.42387695,5.8599707 4.09698242,6.24907227 L10.7827344,12.9348242 L12.9347559,12.9348242 L12.9347559,12.9348926 Z" id="Shape"></path>
                                                <path d="M22.0652441,12.9348926 L22.0652441,12.9348926 L29.8744141,5.1256543 C29.5153906,4.76649414 29.1400293,4.42387695 28.7509277,4.09705078 L22.0652441,10.7828027 L22.0652441,12.9348926 L22.0652441,12.9348926 Z" id="Shape"></path>
                                            </g>
                                        </g>
                                    </g>
                                </svg>
                            </a>
                        @endif

                    </li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>


