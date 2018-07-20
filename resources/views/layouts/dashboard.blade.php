@extends('layouts.app')

<?php

$user = \Auth::user();
$jsonUser = new \App\Http\Resources\UserRessource( $user );
$settingsLang = Lang::get( 'nav.dropdowns.settings' );
$settingsRoutes = [
    'lang_fr' => route( 'lang', 'fr' ),
    'lang_en' => route( 'lang', 'en' ),
    'profile' => route( 'public.profile.home' ),
    'logout'  => route( 'logout' )
];
if ( $user->isAdmin() ) {
    $settingsRoutes['admin'] = route( 'admin.home' );
}

$notificationsRoutes = [
    'api' => [
        'notifications' => route( 'api.notifications' )
    ]
];
$notificationsLang = Lang::get( 'notifications' );

?>

@section('content')

    {{--@component('components.nav')--}}
    {{--@endcomponent--}}

    <div id="dashboard" class="row">
        <div id="side-bar">
            <div class="side-bar-content">
                <div class="top">
                    <div class="logo">
                        <a href="{{route('home')}}">
                            <img class="mx-auto d-md-block d-none" src="{{secure_asset('img/logo-white.png')}}"
                                 alt="logo lastar"/>
                        </a>
                    </div>
                    <div class="profile text-white">
                        <a class="text-white" href="{{route('public.profile.home')}}">
                            <div class="mx-auto text-center pb-2 pb-md-0">
                                <img class="mx-auto rounded-circle" src="{{$user->picture}}" alt="profile_picture"/>
                            </div>
                        </a>

                        <p class="text-center mt-2 d-none d-md-block user-name mb-2">
                            @lang('nav.hello') {{$user->first_name}} ! @if($user->id_verified)
                                <span class="fa-stack fa-lg label-verified d-none d-sm-inline-block">

                              <i class="fa fa-circle fa-stack-1x text-warning"></i>
                              <i class="fa fa-check fa-inverse fa-stack-1x"></i>
                            </span>

                            @endif
                        </p>
                        {{--<p class="text-center mt-2 d-none d-md-block ranking">--}}
                            {{--4.5 <i class="fa fa-star" aria-hidden="true"></i>--}}
                        {{--</p>--}}
                    </div>
                </div>
                <div class="round-up">


                    </svg>
                </div>
                <div class="bottom">
                    <ul class="nav">
                        @include('components.menu')
                    </ul>
                </div>
            </div>
        </div>
        <div class="col bg-light-gray" id="main-content">

            @include('components.nav')

            @yield('dashboard-content')
        </div>
    </div>

@endsection

@push('vue-data')
    <script type="application/javascript">
        {{-- Pass data to main component--}}

            data.navbar = {
            activeLang: window.locale,
            settingsLang: {!! json_encode($settingsLang) !!},
            notificationsLang: {!! json_encode($notificationsLang) !!},
            settingsRoutes: {!! json_encode( $settingsRoutes ) !!},
            notificationsRoutes: {!! json_encode($notificationsRoutes) !!}
        }

    </script>
@endpush

