@extends('admin.layouts.app')

@section('admin-title')
    - ID Verification
@endsection

@section('admin-content')

    <div id="unique-admin" class="id-verification">
        <div class="card">
            <div class="card-header">
                <h5>Id Verification</h5>
            </div>

            <div class="card-body">

                <h4>User Details:</h4>
                <div class="row user-info">
                    <div class="col-12">
                        <a target="_blank" href="{{route('users.edit',$user->id)}}">Link to full profile of {{$user->full_name}}</a>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                        <input-text type="text" name="temp_first_name"
                                    label="First Name" v-model="child.id_check.verifUser.first_name"
                                    :default-value="child.id_check.verifUser.first_name"
                        ></input-text>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                        <input-text type="text" name="temp_last_name"
                                    label="Last Name" v-model="child.id_check.verifUser.last_name"
                                    :default-value="child.id_check.verifUser.last_name"
                        ></input-text>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                        <input-date-admin
                                name="temp_birthdate"
                                v-model="child.id_check.verifUser.birthdate"
                                label="Birthdate"
                                validation="required"
                                placeholder="DD/MM/YYYY"
                                format="dd/MM/yyyy"
                                value-format="dd/MM/yyyy"
                                default-value="{{isset($user)&&$user->birthdate!=null?$user->birthdate->format('d/m/Y'):""}}"
                                default-value-format="DD/MM/YYYY"></input-date-admin>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                        <img class="img-fluid" src="{{$user->picture}}" alt="user_pp"/>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                        <input-select name="type"
                                      label="@lang('profile.modal.verify_identity.type')"
                                      validation="required"
                                      placeholder="@lang('profile.modal.verify_identity.type')"
                                      :options="child.id_check.optionsType"
                                      v-model="child.id_check.idVeryfing.type"
                                      :default-value="child.id_check.idVeryfing.type"
                        ></input-select>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                        <input-country name="country"
                                       label="{{__('profile.modal.verify_identity.country')}}"
                                       validation="required"
                                       placeholder="{{__('profile.modal.verify_identity.country')}}"
                                       :default-value="child.id_check.idVeryfing.country"
                                       v-model="child.id_check.idVeryfing.country"
                        ></input-country>
                    </div>
                </div>
                <h4>Uploaded Id:</h4>
                <div class="row">
                    <div class="col">
                    @if(!$user->idVerification->is_pdf)
                    <img :style="'transform: rotate('+ child.id_check.rotation*90 +'deg);'" class="mx-auto id-scan" src="{{$user->idVerification->scan}}"/>
                    @else
                    <embed src="{{$user->idVerification->scan}}" class="mx-auto id-scan" width="100%" height="400">
                    @endif
                    </div>
                </div>


                <div class="btn-rack mt-5 action-buttons">
                    <form method="post" action="{{route('id_check.accept')}}">
                        {{csrf_field()}}
                        <input type="hidden" name="first_name" :value="child.id_check.verifUser.first_name">
                        <input type="hidden" name="birthdate" :value="child.id_check.verifUser.birthdate">
                        <input type="hidden" name="last_name" :value="child.id_check.verifUser.last_name">
                        <input type="hidden" name="type" :value="child.id_check.idVeryfing.type">
                        <input type="hidden" name="country" :value="child.id_check.idVeryfing.country">

                        <input type="hidden" name="verification_id" value="{{$user->idVerification->id}}">
                        <button type="submit" class="btn btn-success">Accept ID Verification</button>
                    </form>
                    @if(!$user->idVerification->is_pdf)
                        <button class="btn btn-ptb" style="flex-grow: 0;" @click.prevent="child.id_check.rotation=child.id_check.rotation+1">
                            <i class="fa fa-repeat" aria-hidden="true"></i>
                        </button>
                    @endif
                    <button @click.prevent="child.id_check.denyModalOpened=true" class="btn btn-danger">Deny ID Verification</button>
                </div>

                <modal v-cloak :is-open="child.id_check.denyModalOpened" @close-modal="child.id_check.denyModalOpened=false" title="Deny ID Verification">
                    <form method="post" action="{{route('id_check.deny')}}">
                        {{csrf_field()}}
                        <input type="hidden" name="verification_id" value="{{$user->idVerification->id}}">
                        <textarea class="form-control" placeholder="Reasons to deny ID verification" name="comment"></textarea>
                        <button class="btn btn-danger btn-block mt-3" type="submit">Deny ID verification</button>
                    </form>
                </modal>

            </div>
        </div>
    </div>

@endsection

@push('vue-data')
    <script type="application/javascript">
        data.id_check = {
            rotation: 0,
            denyModalOpened: false,
            verifUser: {!! json_encode($jsUser) !!},
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
            idVeryfing: {!! json_encode($user->idVerification) !!}
        }
    </script>
@endpush