
<nav class="navbar navbar-light navbar-expand" id="nav-bar">
    <div class="container-fluid">
        <div class="navbar-header">

        </div>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                {{--<li class="nav-item active">--}}
                    {{--<a class="nav-link" href="#">Dashboard <span class="sr-only">(current)</span></a>--}}
                {{--</li>--}}
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link">
                        <notifications v-cloak></notifications>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link">
                        <settings :lang="lang" :routes="routes" :active-lang="activeLang" :user="user" v-cloak></settings>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" onclick="$crisp.push(['do', 'chat:open'])">
                        <i class="fa fa-question-circle" aria-hidden="true"></i>
                    </a>
                </li>

            {{--@if(Auth::user()->isAdmin())--}}
                {{--<li class="nav-item">--}}
                    {{--<a class="nav-link" href="{{route('admin.home')}}">--}}
                        {{--Admin--}}
                    {{--</a>--}}
                {{--</li>--}}
                {{--@endif--}}
                {{--<li  class="nav-item">--}}
                    {{--<a class="nav-link" href="{{route('logout')}}">--}}
                        {{--{{__('nav.logout')}}--}}
                    {{--</a>--}}
                {{--</li>--}}
                {{--@if (App::isLocale('fr'))--}}
                    {{--<a class="nav-link"href="{{route('lang','en')}}">--}}
                        {{--<span class="flag-icon flag-icon-fr"></span>--}}
                    {{--</a>--}}
                {{--@else--}}
                    {{--<a class="nav-link"href="{{route('lang','fr')}}">--}}
                        {{--<span class="flag-icon flag-icon-gb"></span>--}}
                    {{--</a>--}}
                {{--@endif--}}
            </ul>
        </div>
    </div>
</nav>




