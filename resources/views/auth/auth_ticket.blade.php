@extends('layouts.app')

@php
    // display the correct page name
    $pageName = '';
    switch ($type){
        case 'password_reset':
            $pageName = 'auth.reset.title';
            break;

        case 'login':
            $pageName = 'auth.auth.title';
            break;

        case 'register':
            $pageName = 'auth.register.title';
            break;

    }
@endphp

@section('title')
    - @lang($pageName)
@endsection

@section('content')

    <div class="row auth" id="authComponent">
        <div class="col-12 col-sm-6 purple-gradient left-panel">
            <div class="content">
                <a href="{{route('home')}}"><img class="lastar-logo lastar-logo-sm mx-auto" src="{{secure_asset('img/logo.png')}}"></a>
                <div class="actions btn-rack mt-4">
                    <a href="{{route('about.page')}}" class="btn btn-outline-white">
                        About us
                    </a>
                    <button class="btn btn-white" onclick="$crisp.push(['do', 'chat:open'])">
                        Contact us
                    </button>
                </div>
                <div>
                    <ticket :ticket="ticket" :lang="langTickets.component" class-name="mb-0 mt-4 max-sized no-border"></ticket>
                    <p class="text-center mt-3 text-white">{{__('common.ticket.buy_now')}}</p>
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
                <div>
                    <auth :auth-type="authType"
                          :csrf="csrf"
                          :lang="lang"
                          :routes="routes"
                          :old="old"
                          :token="token"
                          :default-email="defaultEmail"
                          :ticket-link="true"
                    ></auth>
                </div>
            </div>
        </div>
    </div>

    <?php
    $routes = [
        'login'           => route( 'login' ),
        'register'        => route( 'register' ),
        'reset_for_email' => route( 'password.post_email' ),
        'reset_password'  => route( 'password.reset.post_new_password' ),
        'facebook'        => route( 'fb.connect' )
    ];
    $lang = Lang::get( 'auth' );
    $langTicket = Lang::get( 'tickets' );
    $old = session()->getOldInput();
    ?>

    @push('scripts')
        <script type="text/javascript">
            var authComponent = new Vue({
                el: '#authComponent',
                data: {
                    authType: '{{$type}}',
                    csrf: '{{csrf_token()}}',
                    lang: {!!json_encode($lang)!!},
                    routes: {!! json_encode($routes)!!},
                    old: {!! $old?json_encode($old):'{}' !!},
                    token: {!! isset($token)?"'".$token."'":'null' !!},
                    defaultEmail: '{{isset($email)?$email:''}}',
                    ticket: {!! json_encode($ticket)!!},
                    langTickets: {!! json_encode( $langTicket) !!}
                }
            });
        </script>
    @endpush

@endsection
