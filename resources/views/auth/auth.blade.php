@extends('layouts.app')

@section('title')
    - @lang('auth.auth.title')
@endsection

@section('content')

    <div class="row auth">
        <div class="col-sm-6 purple-gradient left-panel">
            <div class="content">
                <h1 class="text-white text-center">
                    Lastar
                </h1>
                <h5 class="text-white text-center">Lorem ipsum ivinati genratorum.</h5>
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
        <div class="col-sm-6 right-panel">
            <div class="content" id="authComponent">
                <auth :auth-type="authType"
                      :csrf="csrf"
                      :lang="lang"
                      :routes="routes"
                ></auth>
            </div>
        </div>
    </div>

    <?php
    $routes = [
        'login'    => route( 'login' ),
        'register' => route( 'register' )
    ];
    $lang = Lang::get('auth');
    ?>

    @push('scripts')
        <script type="text/javascript">
            var authComponent = new Vue({
                el: '#authComponent',
                data: {
                    authType: '{{$type}}',
                    csrf: '{{csrf_token()}}',
                    lang: {!!json_encode($lang)!!},
                    routes: {!! json_encode($routes)!!}
                }
            });
        </script>
    @endpush
@endsection
