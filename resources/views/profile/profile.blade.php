@extends('layouts.dashboard')

@section('dashboard-content')
    <div class="container">
        <div class="row" id="profile-home">
            <div class="col-12">
                <div class="card">
                    <div class="card-header card-header-lastar reverse">
                        <h4 class="card-title mb-0">@lang('profile.title')</h4>
                    </div>
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-2 col-lg-4 col-sm-12">
                                <img @click.prevent="modalPictureUploadOpen=true" class="profile-picture mx-auto rounded-circle img-responsive"
                                     src="{{Auth::user()->picture}}" alt="profile_picture"/>
                            </div>
                            <div class="col-md-5 col-lg-4 col-sm-12">
                                <div class="align-middle">
                                    <h4 class="text-uppercase text-center">{{Auth::user()->full_name}}</h4>
                                    <h5 class="text-uppercase text-center">{{Auth::user()->birthdate}}</h5>
                                    @if(Auth::user()->location)
                                        <h5 class="text-uppercase text-center">{{Auth::user()->location}}</h5>
                                    @endif
                                    @if(Auth::user()->id_verified)
                                        <h5 class="text-center">@lang('profile.account_verified') <i class="fa fa-check-circle text-warning" aria-hidden="true"></i></h5>
                                    @endif
                                    <br>
                                    <h5 class="text-center">{{Auth::user()->phone}}</h5>
                                    <h5 class="text-center">{{Auth::user()->email}}</h5>
                                </div>
                            </div>
                            <div class="col-md-5 col-lg-4 col-sm-12">
                                @if(!Auth::user()->id_verified && Auth::user()->idVerification == null)
                                <button class="btn btn-block btn-lastar-blue" @click.prevent="modalVerifyIdentity=true">@lang('profile.account_verify') <i
                                            class="fa fa-check-circle text-warning" aria-hidden="true"></i>
                                </button>
                                @endif
                                <button class="btn btn-block btn-lastar-blue" @click.prevent="modalPasswordOpen=true">@lang('profile.change_password')
                                </button>
                                <button class="btn btn-block btn-lastar-blue" @click.prevent="modalInfoOpen=true">@lang('profile.edit_profile')
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card card-stats">
                    <div class="card-header card-header-lastar reverse">
                        <h4 class="card-title mb-0">@lang('profile.stats_title')</h4>
                    </div>
                    <div class="card-body">

                    </div>
                </div>

                {{-- Modals --}}
                @if(!Auth::user()->id_verified && Auth::user()->idVerification == null)

                <modal v-cloak :is-open="modalVerifyIdentity" @close-modal="modalVerifyIdentity=false" title="@lang('profile.modal.verify_identity.title')">
                    <div class="modal-body text-justify">
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

                <modal v-cloak :is-open="modalInfoOpen" @close-modal="modalInfoOpen=false" title="@lang('profile.modal.edit_profile.title')">
                    <div class="modal-body text-justify">
                        <p>@lang('profile.modal.edit_profile.content')</p>
                        <button onclick="$crisp.push(['do', 'chat:open'])" class="btn btn-block btn-lastar-blue">@lang('profile.modal.edit_profile.cta')</button>
                    </div>
                </modal>

                <modal v-cloak :is-open="modalPasswordOpen" @close-modal="modalPasswordOpen=false" title="@lang('profile.modal.change_password.title')">
                    <div class="modal-body">
                        <form method="post" action="{{route('public.profile.password.change')}}">
                            {{csrf_field()}}
                            <change-password :lang="langChangePassword"></change-password>
                            <button type="submit" class="btn btn-block btn-lastar-blue">@lang('profile.modal.change_password.cta')</button>
                        </form>
                    </div>
                </modal>

                <modal v-cloak :is-open="modalPictureUploadOpen" @close-modal="modalPictureUploadOpen=false" title="{{__('profile.modal.change_picture.title')}}">
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
            </div>
@endsection


@push('scripts')
    <?php
        $langPasswordModal = Lang::get( 'profile.modal.change_password.component' );

    ?>
    <script type="text/javascript">
        var profile = new Vue({
            el: '#profile-home',
            data: {
                modalInfoOpen: false,
                modalPasswordOpen: false,
                modalPictureUploadOpen: false,
                modalVerifyIdentity: false,
                user: {!! json_encode($user) !!},
                langChangePassword: {!! json_encode($langPasswordModal) !!},
            }
        });
    </script>
@endpush


