@extends('layouts.app')

@section('title')
    - Facebook Connect
@endsection

@section('content')

    <div class="row auth">
        <div class="col-12 col-sm-6 purple-gradient left-panel">
            {{--TODO: full sticky only visible on large screens, remains to do mobile version--}}
            <div class="content">
                <a href="{{route('home')}}"><img class="lastar-logo mx-auto" src="{{secure_asset('img/logo.png')}}"></a>
                <div class="actions btn-rack mt-4">
                    <button class="btn btn-white">
                        Find a ticket
                    </button>
                    <button class="btn btn-outline-white">
                        Contact us
                    </button>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 right-panel">
            <div class="lang">
                @if (App::isLocale('fr'))
                    <a href="{{route('lang','en')}}">
                        <span class="flag-icon flag-icon-gb"></span>
                    </a>
                @else
                    <a href="{{route('lang','fr')}}">
                        <span class="flag-icon flag-icon-fr"></span>
                    </a>
                @endif
            </div>
            <div class="content">

                <social-password :user="child.social_pwd.social_user"
                                 :lang-auth="child.social_pwd.lang_auth"
                                 :lang-profile="child.social_pwd.lang_profile"
                                 :route-fb-confirm="child.social_pwd.route_fb_confirm"
                >
                </social-password>
            </div>
        </div>
    </div>
@endsection

@push('vue-data')
    <script type="application/javascript">

        data.social_pwd = {
            lang_profile: {!! json_encode(__('profile')) !!},
            lang_auth: {!! json_encode(__('auth')) !!},
            social_user: {!! json_encode($user) !!},
            route_fb_confirm: "{{route('fb.confirm')}}"
        }

    </script>
@endpush
