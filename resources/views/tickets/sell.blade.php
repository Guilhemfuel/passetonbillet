@extends('layouts.dashboard')

@section('title')
    - Sell Ticket
@endsection

@section('dashboard-content')
    <div class="container">
        <div class="row" id="sell-ticket">
            @if(Auth::user()->phone_verified)

                @if (Auth::user()->id_uploaded)
                    <sell-ticket :api="child.sell_tickets.api" :lang="child.sell_tickets.lang" :user="user" :routes="child.sell_tickets.routes"></sell-ticket>
                @else
                    <div class="col-sm-12">
                        <h4 class="card-title mb-0">@lang('tickets.sell.title')</h4>
                        <div class="card">
                            <div class="card-body justify-content-center d-flex">
                                <div class="col-sm-12 col-md-10 col-lg-6">
                                    <img class="mx-auto d-block mb-3 ptb-icon" style="width: 150px" src="{{secure_asset('img/icones/ptb-icon-id.png')}}">
                                    <p class="text-justify">@lang('profile.modal.verify_identity.text')</p>
                                    <p class="text-justify">@lang('profile.modal.verify_identity.list_title'):</p>
                                    <ul>
                                        @foreach( __('profile.modal.verify_identity.list_id') as $item)
                                            <li>{{$item}}</li>
                                        @endforeach
                                    </ul>
                                    <form method="post" action="{{route('public.profile.id.upload')}}" enctype="multipart/form-data">
                                        {{csrf_field()}}
                                        <div class="form-group">
                                            <input class="form-control" type="file" name="scan">
                                        </div>
                                        <button type="submit" class="btn btn-block btn-ptb-blue">@lang('profile.modal.change_picture.cta')</button>
                                    </form>
                                    <br>
                                    <p class="text-center">@lang('profile.modal.verify_identity.delay')</p>
                                </div>

                            </div>
                        </div>
                    </div>
                @endif
            @else

                @if(!Auth::user()->phone_verification_sent)
                    <div class="col-sm-12">
                        <h4 class="card-title mb-0">@lang('tickets.sell.title')</h4>

                        <div class="card">
                            <div class="card-body">
                                <p class="card-text text-justify">
                                   @lang('tickets.sell.confirm_number.last_step')
                                </p>
                                <form method="post" action="{{route('public.profile.phone.add')}}">
                                    {{csrf_field()}}
                                    <div class="row">

                                        <div class="col-sm-12 col-md-6">

                                            <div class="form-group">
                                                <phone country-value="{{App::isLocale('fr')?'FR':'GB'}}"></phone>
                                            </div>

                                        </div>
                                        <div class="col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-ptb-blue btn-block">
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
                        <h4 class="card-title mb-0">@lang('tickets.sell.title')</h4>
                        <div class="card">
                            <div class="card-body">
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
                                                <button type="submit" class="btn btn-ptb-blue btn-block">
                                                    @lang('tickets.sell.confirm_number.CTA')
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <a href="#" @click.prevent="child.sell_tickets.resendNumberModalOpen=true">@lang('tickets.sell.confirm_number.no_code_received')</a>

                                <modal v-cloak :is-open="child.sell_tickets.resendNumberModalOpen" @close-modal="child.sell_tickets.resendNumberModalOpen=false">
                                    <div class="modal-body">
                                        <p class="text-justify">
                                            @lang('tickets.sell.confirm_number.last_step')
                                        </p>
                                        <form method="post" action="{{route('public.profile.phone.add')}}">
                                            {{csrf_field()}}
                                            <div class="row">

                                                <div class="col-md-12">

                                                    <div class="form-group">
                                                        <phone country-value="{{App::isLocale('fr')?'FR':'GB'}}"></phone>
                                                    </div>

                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <button type="submit" class="btn btn-ptb-blue btn-block">
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

<?php
    $lang = Lang::get( 'tickets' );
    $routes = [
        'tickets' => [
            'sell' => route( 'public.ticket.sell.post' )
        ]
    ]
?>


@push('vue-data')
    <script type="text/javascript">
        data.sell_tickets = {
            api: {
                tickets: {
                    search: '{!! route('api.tickets.search') !!}'
                }
            },
            lang: {!!json_encode($lang)!!},
            routes: {!! json_encode($routes) !!},

            resendNumberModalOpen: false
        }
    </script>
@endpush