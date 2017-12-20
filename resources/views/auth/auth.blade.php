@extends('layouts.app')

@section('title')
    - @lang('auth.auth.title')
@endsection

@section('content')

    <div class="row auth">
        <div class="col-12 col-sm-6 purple-gradient left-panel">
            {{--TODO: full sticky only visible on large screens, remains to do mobile version--}}
            <div class="content">
                <a href="{{route('home')}}"><img class="lastar-logo mx-auto" src="{{asset('img/logo.png')}}"></a>
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
                    <a  href="{{route('lang','en')}}">
                        <span class="flag-icon flag-icon-fr"></span>
                    </a>
                @else
                    <a href="{{route('lang','fr')}}">
                        <span class="flag-icon flag-icon-gb"></span>
                    </a>
                @endif
            </div>
            <div class="content">
            @if(count(session('flash_notification'))>0 || (isset($errors) && count($errors)>0))
                <!-- Alert Container -->
                    <div class="alert-sticky container" id="flash-container">
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

                <div id="authComponent">
                    <auth :auth-type="authType"
                          :csrf="csrf"
                          :lang="lang"
                          :routes="routes"
                          :old="old"
                          :back-errors="backErrors"
                          :token="token"
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
    ];
    $lang = Lang::get( 'auth' );
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
                    backErrors: {!! $errors?json_encode($errors->all()):'{}' !!},
                    token: {!! isset($token)?"'".$token."'":'null' !!}
                }
            });
        </script>
    @endpush
    @if(count(session('flash_notification'))>0 || (isset($errors) && count($errors)>0))
        @push('scripts')
            <script type="application/javascript">
                var flashContainer = new Vue({
                    el: '#flash-container',
                    data: {
                        messages: {!! json_encode(session('flash_notification', collect())->toArray()?:[]) !!},
                        validationErrors: {!! isset($errors)?json_encode($errors->all()):'[]' !!},
                    }
                });
            </script>
        @endpush
    @endif
@endsection