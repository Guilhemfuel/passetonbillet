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
        <div id="side-bar" class="col-sm-4 col-md-3 purple-gradient">
            <div class="side-bar-content">
                <div class="logo">
                    <a href="{{route('home')}}">
                        <img class="mx-auto d-sm-block d-none" src="{{secure_asset('img/logo.png')}}"
                             alt="logo lastar"/>
                    </a>
                </div>
                <div class="profile">
                    <a class="text-white" href="{{route('public.profile.home')}}">
                        <div class="mx-auto text-center">
                            <img class="mx-auto rounded-circle" src="{{$user->picture}}" alt="profile_picture"/>
                        </div>
                        <p class="text-center mt-2 d-none d-sm-block">
                            {{$user->full_name}}@if($user->id_verified)
                                <span class="fa-stack fa-lg label-verified d-none d-sm-inline-block">
                              <i class="fa fa-circle fa-stack-1x text-warning"></i>
                              <i class="fa fa-check fa-inverse fa-stack-1x"></i>
                            </span>
                            @endif
                        </p>
                    </a>
                </div>
                <ul class="nav">
                    @include('components.menu')
                </ul>
            </div>
        </div>
        <div class="col-sm-8 col-md-9 col bg-light-gray" id="main-content">

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

