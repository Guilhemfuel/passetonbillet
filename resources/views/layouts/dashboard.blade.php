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
        'notifications' => route('api.notifications')
    ]
];
$notificationsLang = Lang::get('notifications');

$activeLang = App::getLocale();

?>

@section('content')

    {{--@component('components.nav')--}}
    {{--@endcomponent--}}

    <div id="dashboard" class="row">
        <div id="side-bar" class="col-sm-4 col-md-3 purple-gradient">
            <div class="logo">
                <img class="mx-auto d-sm-block d-none" src="{{asset('img/logo.png')}}" alt="logo lastar"/>
            </div>
            <div class="profile">
                <a class="text-white" href="{{route('public.profile.home')}}">
                    <div class="mx-auto text-center">
                        <img class="mx-auto rounded-circle" src="{{$user->picture}}" alt="profile_picture"/>
                    </div>
                    <p class="text-center mt-2 d-none d-sm-block">
                        {{$user->full_name}}
                        @if($user->id_verified)
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
        <div class="col-sm-8 col-md-9 col bg-light-gray">

        @include('components.nav')

        @if( (session('flash_notification')!==null && count(session('flash_notification'))>0) || (isset($errors) && count($errors)>0))
        <!-- Alert Container -->
            <div class="alert-sticky container mt-4" id="flash-container">
                <flash v-for="message in messages"
                       v-if="!message.overlay"
                       :type="message.level"
                       :content="message.message"
                       :important="message.important"></flash>
                <flash v-for="error in validationErrors"
                       type="danger"
                       :content="error"
                       :important="true"></flash>
            </div>
        @endif

            @yield('dashboard-content')
        </div>
    </div>

@endsection

@push('scripts')

    <script type="application/javascript">
        const sidebar = new Vue({
            el: '#side-bar',
            data: {
                important: false
            }
        });
        const navbar = new Vue({
            el: '#nav-bar',
            data: {
                activeLang: "{{$activeLang}}",
                settingsLang: {!! json_encode($settingsLang) !!},
                notificationsLang: {!! json_encode($notificationsLang) !!},
                settingsRoutes: {!! json_encode( $settingsRoutes ) !!},
                notificationsRoutes: {!! json_encode($notificationsRoutes) !!},
                user: {!! json_encode($jsonUser) !!},
            }
        });
    </script>
@endpush

