@extends('layouts.dashboard')

@section('title')
    - Profile
@endsection

@section('dashboard-content')
    <div class="container">
        <div class="row" id="profile-home">
            <div class="col-12">
                <div class="card-title mb-0"> @lang('profile.title') </div>

                <div class="card">
                    {{-- View  User--}}
                    @if(\Auth::user()->id == $user->id)
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-2 col-lg-4 col-sm-12">
                                    <img @click.prevent="child.profile.modalPictureUploadOpen=true"
                                         class="profile-picture mx-auto rounded-circle img-responsive"
                                         src="{{$user->picture}}" alt="profile_picture"/>
                                </div>
                                <div class="col-sm-12 col-md-5 col-lg-4">
                                    <div class="align-middle">
                                        <h4 class="text-center text-full-name">{{$user->full_name}}</h4>
                                        <h5 class="text-center" v-cloak>@{{ this.trans('profile.member_since') }}
                                            @{{this.$moment(user.created_at.date).format('LL')}}</h5>
                                        @if($user->location)
                                            <h5 class="text-center">{{$user->location}}</h5>
                                        @endif
                                        @if($user->id_verified)
                                            <h5 class="text-center">@lang('profile.account_verified') <i
                                                        class="fa fa-check-circle text-warning" aria-hidden="true"></i>
                                            </h5>
                                        @endif
                                        <h5 class="text-center">{{$user->tickets()->whereNotNull('sold_to_id')->count()}} @lang('profile.number_tickets_successfully_sold')</h5>
                                        <br>
                                        <p class="private-limit">@lang("profile.only_you")</p>
                                        <h5 class="text-center">{{$user->last_name}}</h5>
                                        <h5 class="text-center">{{$user->phone}}</h5>
                                        <h5 class="text-center">{{$user->email}}</h5>
                                    </div>
                                </div>
                                <div class="col-md-5 col-lg-4 col-sm-12 mt-xs-4">
                                    @if(!$user->id_verified && $user->idVerification == null)
                                        <button class="btn btn-block btn-warning"
                                                @click.prevent="child.profile.modalVerifyIdentity=true">@lang('profile.account_verify')
                                            <i
                                                    class="fa fa-check-circle pl-2" aria-hidden="true"></i>
                                        </button>
                                    @elseif(!$user->id_verified && $user->idVerification != null)
                                        <button class="btn btn-block btn-warning" disabled
                                                @click.prevent="child.profile.modalVerifyIdentity=true">@lang('profile.verification_pending')
                                            <i class="fa fa-clock-o" aria-hidden="true"></i>

                                        </button>
                                    @endif
                                    <button class="btn btn-block btn-ptb-blue"
                                            @click.prevent="child.profile.modalPasswordOpen=true">@lang('profile.change_password')
                                    </button>
                                    <button class="btn btn-block btn-ptb-blue"
                                            @click.prevent="child.profile.modalNameOpen=true">@lang('profile.change_name')
                                    </button>
                                    <button class="btn btn-block btn-ptb-blue"
                                            @click.prevent="child.profile.modalInfoOpen=true">@lang('profile.edit_profile')
                                    </button>
                                    <button class="btn btn-block btn-ptb-blue"
                                            @click.prevent="child.profile.modalPictureUploadOpen=true">@lang('profile.change_picture')
                                    </button>
                                    <a class="btn btn-block btn-ptb-blue text-white" onclick="window.__cmp('displayConsentUi');">@lang('profile.privacy_settings')</a>

                                    <delete-account></delete-account>

                                </div>
                            </div>
                        </div>
                    @else
                        {{-- View Guest--}}
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-4 col-sm-12 col-12">
                                    <img @click.prevent="modalPictureUploadOpen=true"
                                         class="profile-picture mx-auto rounded-circle img-responsive"
                                         src="{{$user->picture}}" alt="profile_picture"/>
                                </div>
                                <div class="col-sm-12 col-12 col-md-4">
                                    <div class="align-middle">
                                        <h4 class="text-uppercase text-center">{{$user->full_name}}</h4>
                                        @if($user->location)
                                            <h5 class="text-uppercase text-center">{{$user->location}}</h5>
                                        @endif
                                        @if($user->id_verified)
                                            <h5 class="text-center">@lang('profile.account_verified') <i
                                                        class="fa fa-check-circle text-warning" aria-hidden="true"></i>
                                            </h5>
                                        @endif
                                        <h5 class="text-center">{{$user->member_since}}</h5>

                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="align-middle mt-3">
                                        <h5 class="text-center text-primary">{{$user->tickets()->whereNotNull('sold_to_id')->count()}}</h5>
                                        <h5 class="text-center">@lang('profile.number_tickets_successfully_sold')
                                            <br>@lang('profile.by') {{$user->full_name}}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>

                    @endif
                </div>

                {{-- Modals --}}

                {{-- ID VERIFICATION MODAL --}}
                @if(!Auth::user()->id_verified && Auth::user()->idVerification == null)

                    <modal v-cloak :is-open="child.profile.modalVerifyIdentity"
                           @close-modal="child.profile.modalVerifyIdentity=false"
                           title="@lang('profile.modal.verify_identity.title')">
                        <div class="modal-body text-justify pt-0">
                            <img class="mx-auto d-block mb-3 ptb-icon"
                                 src="{{secure_asset('img/icones/ptb-icon-id.png')}}">
                            <p>@lang('profile.modal.verify_identity.text')</p>
                            <p>@lang('profile.modal.verify_identity.list_title'):</p>
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
                                              :options="child.profile.optionsType"
                                ></input-select>
                                <input-country name="country"
                                               label="{{__('profile.modal.verify_identity.country')}}"
                                               validation="required"
                                               placeholder="{{__('profile.modal.verify_identity.country')}}"
                                ></input-country>
                                <button type="submit"
                                        class="btn btn-block btn-ptb-blue">@lang('profile.modal.verify_identity.cta')</button>
                            </vue-form>
                            <br>
                            <p class="text-center">@lang('profile.modal.verify_identity.delay')</p>
                        </div>
                    </modal>

                @endif

                {{-- MODAL NAME --}}

                <modal v-cloak :is-open="child.profile.modalNameOpen" @close-modal="child.profile.modalNameOpen=false"
                       title="@lang('profile.modal.change_name.title')">
                    <div class="modal-body text-justify">
                        <p>{!! __('profile.modal.change_name.content') !!}</p>
                    </div>
                </modal>

                {{-- MODAL INFO --}}

                <modal v-cloak :is-open="child.profile.modalInfoOpen" @close-modal="child.profile.modalInfoOpen=false"
                       title="@lang('profile.modal.edit_profile.title')">
                    <div class="modal-body text-justify">
                        <p>@lang('profile.modal.edit_profile.content')</p>
                        <button onclick="$crisp.push(['do', 'chat:open'])"
                                class="btn btn-block btn-ptb-blue">@lang('profile.modal.edit_profile.cta')</button>
                    </div>
                </modal>

                {{-- MODAL PASSWORD --}}

                <modal v-cloak :is-open="child.profile.modalPasswordOpen"
                       @close-modal="child.profile.modalPasswordOpen=false"
                       title="@lang('profile.modal.change_password.title')">
                    <div class="modal-body">
                        <form method="post" action="{{route('public.profile.password.change')}}">
                            {{csrf_field()}}
                            <change-password :lang="child.profile.langChangePassword"></change-password>
                            <button type="submit"
                                    class="btn btn-block btn-ptb-blue">@lang('profile.modal.change_password.cta')</button>
                        </form>
                    </div>
                </modal>

                {{-- MODAL PICTURE --}}

                <modal v-cloak :is-open="child.profile.modalPictureUploadOpen"
                       @close-modal="child.profile.modalPictureUploadOpen=false"
                       title="{{__('profile.modal.change_picture.title')}}">
                    <div class="modal-body text-justify">
                        <form method="post" action="{{route('public.profile.picture.upload')}}"
                              enctype="multipart/form-data">
                            {{csrf_field()}}
                            <p>@lang('profile.modal.change_picture.text')</p>
                            <div class="form-group">
                                <input class="form-control" type="file" name="picture">
                            </div>
                            <button type="submit"
                                    class="btn btn-block btn-ptb-blue">@lang('profile.modal.change_picture.cta')</button>
                        </form>
                    </div>
                </modal>

                @if(\Auth::user()->id != $user->id && isset($tickets) && $tickets->count() > 0)
                    <h3 class="mt-4 mb-0 text-center">@lang('common.ticket.name')s</h3>
                    <div class="tickets row">
                        <div class="col-12 col-sm-12 col-md-6 col-lg-4" v-for="ticket in child.profile.tickets">
                            <ticket :ticket="ticket" :api="child.profile.ticketsAPI" :lang="child.profile.langTickets"
                                    :user="user" :buying="child.profile.true" class-name="mt-4"></ticket>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection

<?php
$langPasswordModal = Lang::get( 'profile.modal.change_password.component' );
$langTickets = Lang::get( 'tickets.component' );
$api = [
    'tickets' => [
        'buy'   => route( 'api.tickets.buy' ),
        'offer' => route( 'api.tickets.offer' )
    ]
];
?>

@push('vue-data')
    <script type="application/javascript">
        /**
         * Page data
         */
        data.profile = {
            modalInfoOpen: false,
            modalPasswordOpen: false,
            modalPictureUploadOpen: false,
            modalNameOpen: false,
            modalVerifyIdentity: false,
            langChangePassword: {!! json_encode($langPasswordModal) !!},
            tickets: {!! isset($tickets)?json_encode($tickets):"null" !!},
            ticketsAPI: {!! json_encode($api) !!},
            langTickets: {!! json_encode($langTickets) !!},
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
            ]) !!}
        }
    </script>
@endpush
