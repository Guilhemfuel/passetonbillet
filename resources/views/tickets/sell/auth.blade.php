@extends('layouts.dashboard')

@section('title')
    - Sell Ticket
@endsection

@section('dashboard-content')
    <div class="container">
        <div class="row" id="sell-ticket">



            @if(Auth::user()->phone_verified)

                <sell-ticket :api="child.sell_tickets.api" :user="user" :routes="child.sell_tickets.routes"></sell-ticket>

                @if (Auth::user()->id_uploaded)

                @else

                    {{-- Verify identity--}}

                {{--
                <div class="col-sm-12">
                        <h1 class="card-title mb-0">@lang('tickets.sell.title')</h1>
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
                                    <vue-form method="POST" action="{{route('public.profile.id.upload')}}"
                                              enctype="multipart/form-data">
                                        <div class="form-group">
                                            <input class="form-control" type="file" name="scan">
                                        </div>
                                        <input-select name="type"
                                                      label="@lang('profile.modal.verify_identity.type')"
                                                      validation="required"
                                                      placeholder="@lang('profile.modal.verify_identity.type')"
                                                      :options="child.sell_tickets.optionsType"
                                        ></input-select>
                                        <input-country name="country"
                                                       label="{{__('profile.modal.verify_identity.country')}}"
                                                       validation="required"
                                                       placeholder="{{__('profile.modal.verify_identity.country')}}"
                                        ></input-country>
                                        <button type="submit" class="btn btn-block btn-ptb-blue">@lang('profile.modal.verify_identity.cta')</button>
                                    </vue-form>
                                    <br>
                                    <p class="text-center">@lang('profile.modal.verify_identity.delay')</p>
                                </div>

                            </div>
                        </div>
                    </div>
                --}}

                @endif
            @else

                {{-- Verify Phone--}}

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

                    {{-- Enter code received by sms--}}

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
    $routes = [
        'tickets' => [
            'sell' => route( 'public.ticket.sell.post' )
        ]
    ]
?>


@push('vue-data')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.3.200/pdf.min.js" integrity="sha256-J4Z8Fhj2MITUakMQatkqOVdtqodUlwHtQ/ey6fSsudE=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.3.200/pdf.worker.js" integrity="sha256-dJSOqtDrNjfG3bC2bSZAHCZgE4zQT0Js6brOkFp8PE8=" crossorigin="anonymous"></script>
    <script type="text/javascript">
        data.sell_tickets = {
            api: {
                tickets: {
                    search: '{!! route('api.tickets.search') !!}'
                }
            },
            routes: {!! json_encode($routes) !!},
            optionsType: {!! json_encode([
                [
                    'label' =>  __("profile.modal.verify_identity.list_id.driving_license"),
                    'value' => 'driving_license'
                ],
                 [
                    'label' =>  __("profile.modal.verify_identity.list_id.id_card"),
                    'value' => 'id'
                ],
                 [
                    'label' =>  __("profile.modal.verify_identity.list_id.passport"),
                    'value' => 'passport'
                ]
            ]) !!},

            resendNumberModalOpen: false
        }
    </script>
@endpush