@extends('layouts.dashboard')

@section('dashboard-content')
    <div class="container">
        <div class="row" id="profile-home">
            <div class="col-12">
                <div class="card">
                    <div class="card-header card-header-lastar reverse">
                        <h4 class="card-title mb-0">@lang('profile.title')</h4>
                    </div>
                    @if(\Auth::user()->id == $user->id)
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-2 col-lg-4 col-sm-12">
                                <img @click.prevent="child.profile.modalPictureUploadOpen=true" class="profile-picture mx-auto rounded-circle img-responsive"
                                     src="{{$user->picture}}" alt="profile_picture"/>
                            </div>
                            <div class="col-sm-12 col-md-5 col-lg-4">
                                <div class="align-middle">
                                    <h4 class="text-center text-full-name">{{$user->full_name}}</h4>
                                    <h5 class="text-center">{{$user->member_since}}</h5>
                                    @if($user->location)
                                        <h5 class="text-center">{{$user->location}}</h5>
                                    @endif
                                    @if($user->id_verified)
                                        <h5 class="text-center">@lang('profile.account_verified') <i class="fa fa-check-circle text-warning" aria-hidden="true"></i></h5>
                                    @endif
                                    <br>
                                    <h5 class="text-center">{{$user->phone}}</h5>
                                    <h5 class="text-center">{{$user->email}}</h5>
                                </div>
                            </div>
                            <div class="col-md-5 col-lg-4 col-sm-12 mt-xs-4">
                                @if(!$user->id_verified && $user->idVerification == null)
                                <button class="btn btn-block btn-warning" @click.prevent="child.profile.modalVerifyIdentity=true">@lang('profile.account_verify') <i
                                            class="fa fa-check-circle pl-2" aria-hidden="true"></i>
                                </button>
                                @endif
                                <button class="btn btn-block btn-lastar-blue" @click.prevent="child.profile.modalPasswordOpen=true">@lang('profile.change_password')
                                </button>
                                <button class="btn btn-block btn-lastar-blue" @click.prevent="child.profile.modalInfoOpen=true">@lang('profile.edit_profile')
                                </button>
                                <button class="btn btn-block btn-lastar-blue" @click.prevent="child.profile.modalPictureUploadOpen=true">@lang('profile.change_picture')
                                </button>
                            </div>
                        </div>
                    </div>
                    @else
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-4 col-sm-12 col-12">
                                    <img @click.prevent="modalPictureUploadOpen=true" class="profile-picture mx-auto rounded-circle img-responsive"
                                         src="{{$user->picture}}" alt="profile_picture"/>
                                </div>
                                <div class="col-sm-12 col-12 col-md-4">
                                    <div class="align-middle">
                                        <h4 class="text-uppercase text-center">{{$user->full_name}}</h4>
                                        @if($user->location)
                                            <h5 class="text-uppercase text-center">{{$user->location}}</h5>
                                        @endif
                                        @if($user->id_verified)
                                            <h5 class="text-center">@lang('profile.account_verified') <i class="fa fa-check-circle text-warning" aria-hidden="true"></i></h5>
                                        @endif
                                        <h5 class="text-center">{{$user->member_since}}</h5>

                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="align-middle mt-3">
                                        <h5 class="text-center text-primary">0</h5>
                                        <h5 class="text-center">@lang('profile.number_tickets_successfully_sold')<br>by {{$user->full_name}}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>

                    @endif
                </div>

                {{-- Modals --}}
                @if(!Auth::user()->id_verified && Auth::user()->idVerification == null)

                <modal v-cloak :is-open="child.profile.modalVerifyIdentity" @close-modal="child.profile.modalVerifyIdentity=false" title="@lang('profile.modal.verify_identity.title')">
                    <div class="modal-body text-justify pt-0">
                        <img class="mx-auto d-block mb-3 lastar-icon" src="{{secure_asset('img/icones/lastar-icon-id.png')}}">
                        <p>@lang('profile.modal.verify_identity.text')</p>
                        <p>@lang('profile.modal.verify_identity.list_title'):</p>
                        <ul>
                            @foreach( __('profile.modal.verify_identity.list_id') as $item)
                                <li>{{$item}}</li>
                            @endforeach
                        </ul>
                        <form method="post" action="{{route('public.profile.id.upload')}}" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <p>@lang('profile.modal.change_picture.text')</p>
                            <div class="form-group">
                                <input class="form-control" type="file" name="scan">
                            </div>
                            <button type="submit" class="btn btn-block btn-lastar-blue">@lang('profile.modal.change_picture.cta')</button>
                        </form>
                        <br>
                        <p class="text-center">@lang('profile.modal.verify_identity.delay')</p>
                    </div>
                </modal>

                @endif

                <modal v-cloak :is-open="child.profile.modalInfoOpen" @close-modal="child.profile.modalInfoOpen=false" title="@lang('profile.modal.edit_profile.title')">
                    <div class="modal-body text-justify">
                        <p>@lang('profile.modal.edit_profile.content')</p>
                        <button onclick="$crisp.push(['do', 'chat:open'])" class="btn btn-block btn-lastar-blue">@lang('profile.modal.edit_profile.cta')</button>
                    </div>
                </modal>

                <modal v-cloak :is-open="child.profile.modalPasswordOpen" @close-modal="child.profile.modalPasswordOpen=false" title="@lang('profile.modal.change_password.title')">
                    <div class="modal-body">
                        <form method="post" action="{{route('public.profile.password.change')}}">
                            {{csrf_field()}}
                            <change-password :lang="child.profile.langChangePassword"></change-password>
                            <button type="submit" class="btn btn-block btn-lastar-blue">@lang('profile.modal.change_password.cta')</button>
                        </form>
                    </div>
                </modal>

                <modal v-cloak :is-open="child.profile.modalPictureUploadOpen" @close-modal="child.profile.modalPictureUploadOpen=false" title="{{__('profile.modal.change_picture.title')}}">
                    <div class="modal-body text-justify">
                        <form method="post" action="{{route('public.profile.picture.upload')}}" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <p>@lang('profile.modal.change_picture.text')</p>
                            <div class="form-group">
                                <input class="form-control" type="file" name="picture">
                            </div>
                            <button type="submit" class="btn btn-block btn-lastar-blue">@lang('profile.modal.change_picture.cta')</button>
                        </form>
                    </div>
                </modal>

                @if(\Auth::user()->id != $user->id && isset($tickets) && $tickets->count() > 0)
                    <h3 class="mt-4 mb-0 text-center">@lang('common.ticket.name')s</h3>
                    <div class="tickets row">
                        <div class="col-12 col-sm-12 col-md-6 col-lg-4" v-for="ticket in tickets">
                            <ticket :ticket="child.profile.ticket" :api="child.profile.ticketsAPI" :lang="child.profile.langTickets" :user="user" :buying="child.profile.true" class-name="mt-4"></ticket>
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
            'buy' => route('api.tickets.buy'),
            'offer' => route('api.tickets.offer')
        ]
    ];
?>

@push('vue-data')
    <script type="application/javascript">
        data.profile = {
            modalInfoOpen: false,
            modalPasswordOpen: false,
            modalPictureUploadOpen: false,
            modalVerifyIdentity: false,
            langChangePassword: {!! json_encode($langPasswordModal) !!},
            tickets: {!! isset($tickets)?json_encode($tickets):"null" !!},
            ticketsAPI: {!! json_encode($api) !!},
            langTickets: {!! json_encode($langTickets) !!}
        }
    </script>
@endpush
