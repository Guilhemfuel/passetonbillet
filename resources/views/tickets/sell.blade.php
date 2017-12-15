@extends('layouts.dashboard')

@section('dashboard-content')
    <div class="container-fluid">
        <div class="row" id="sell-ticket">
            @if(Auth::user()->phone_verified)
                <sell-ticket :api="api" :lang="lang" :user="user" :csrf="csrf" :routes="routes"></sell-ticket>
            @else

                @if(!Auth::user()->phone_verification_sent)
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">
                                    @lang('tickets.sell.title')
                                </h4>
                                <p class="card-text text-justify">
                                   @lang('tickets.sell.confirm_number.last_step')
                                </p>
                                <form method="post" action="{{route('public.profile.phone.add')}}">
                                    {{csrf_field()}}
                                    <div class="row">

                                        <div class="col-sm-12 col-md-6">

                                            <div class="form-group">
                                                <phone></phone>
                                            </div>

                                        </div>
                                        <div class="col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-lastar-blue btn-block">
                                                    @lang('tickets.sell.confirm_number.CTA')
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                @else
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">
                                    @lang('tickets.sell.title')
                                </h4>
                                <p class="card-text text-justify">
                                    @lang('tickets.sell.confirm_number.code_check')
                                </p>
                                <form method="post" action="{{route('public.profile.phone.verify')}}">
                                    {{csrf_field()}}
                                    <div class="row">

                                        <div class="col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <cleave type="text"
                                                        class="form-control"
                                                        placeholder="XXXXXX"
                                                        :options="{ numericOnly: true, blocks:[6] }"
                                                        name="code"></cleave>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-lastar-blue btn-block">
                                                    @lang('tickets.sell.confirm_number.CTA')
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <a href="#" @click.prevent="resendNumberModalOpen=true">@lang('tickets.sell.confirm_number.no_code_received')</a>

                                <modal v-cloak :is-open="resendNumberModalOpen" @close-modal="resendNumberModalOpen=false">
                                    <div class="modal-body">
                                        <p class="text-justify">
                                            @lang('tickets.sell.confirm_number.last_step')
                                        </p>
                                        <form method="post" action="{{route('public.profile.phone.add')}}">
                                            {{csrf_field()}}
                                            <div class="row">

                                                <div class="col-md-12">

                                                    <div class="form-group">
                                                        <phone></phone>
                                                    </div>

                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <button type="submit" class="btn btn-lastar-blue btn-block">
                                                            @lang('tickets.sell.confirm_number.CTA')
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </modal>
                            </div>
                        </div>
                    </div>
                @endif

            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <?php
    $lang = Lang::get( 'tickets' );
    $routes = [
        'tickets' => [
            'sell' => route( 'public.ticket.sell.post' )
        ]
    ]
    ?>

    <script type="text/javascript">
        var sellTicket = new Vue({
            el: '#sell-ticket',
            data: {
                api: {
                    tickets: {
                        search: '{!! route('api.tickets.search') !!}'
                    }
                },
                lang: {!!json_encode($lang)!!},
                user: {!! json_encode($user) !!},
                csrf: '{!! csrf_token() !!}',
                routes: {!! json_encode($routes) !!},

                resendNumberModalOpen: false

            }
        });
    </script>
@endpush