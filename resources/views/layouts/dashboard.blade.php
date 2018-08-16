@extends('layouts.app')

<?php

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

?>

@section('content')


    <div id="dashboard" class="row">
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
            settingsRoutes: {!! json_encode( $settingsRoutes ) !!},
        }

    </script>
@endpush

