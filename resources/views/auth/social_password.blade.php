@extends('layouts.app')

@section('title')
    - Facebook Connect
@endsection

@section('content')

    <div class="row auth">
        <div class="col-12 col-sm-6 purple-gradient left-panel">
            {{--TODO: full sticky only visible on large screens, remains to do mobile version--}}
            <div class="content">
                <a href="{{route('home')}}"><img class="lastar-logo mx-auto" src="{{secure_asset('img/logo.png')}}"></a>
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

                    <social-register v-cloak>
                        <img class="profile-picture rounded-circle mx-auto" src="{{$user->avatar}}">
                        <h2 class="text-center txt-primary mt-2">Hello {{$user->user['first_name']}}!</h2>
                        <p class="mt-3">@lang('auth.social.last_step_pwd')</p>
                        <form role="form"
                              method="POST"
                              id="pwd-form"
                              action="{{route('fb.confirm')}}"
                        >
                            {{csrf_field()}}

                            <div class="col-xs-12 form-group">
                                <label for="password"
                                       class="control-label">@lang('profile.modal.change_password.component.password')
                                    <small class="text-muted">(8 char. min)</small>
                                </label>
                                <input id="password" type="password"
                                       class="form-control"
                                       name="password"
                                       v-validate="'required|min:8'"
                                       required placeholder="@lang('profile.modal.change_password.component.password')">
                                <span v-cloak v-if="errors.has('password')" class="invalid-feedback d-inline">@{{ errors.first('password') }}</span>

                            </div>

                            <div class="col-xs-12 form-group">
                                <label for="password-confirm"
                                       class="control-label">@lang('profile.modal.change_password.component.password_confirm')</label>

                                <input id="password-confirm" type="password"
                                       class="form-control"
                                       name="password_confirmation"
                                       v-validate="'required|confirmed:password|min:8'"
                                       required
                                       placeholder="@lang('profile.modal.change_password.component.password_confirm')">
                                <span v-cloak
                                      :class="{'invalid-feedback':true,'d-inline':errors.has('password_confirmation')}">@{{ errors.first('password_confirmation') }}</span>
                            </div>

                            <div class="form-group mt-4">
                                <div class="col-xs-12">
                                    <button class="btn btn-lastar-blue btn-block" @click.prevent="validateBeforeSubmit">
                                        @lang('auth.register.title')
                                    </button>
                                </div>
                            </div>

                        </form>
                    </social-register>
            </div>
        </div>
    </div>
@endsection

@push('vue-data')
    <script type="application/javascript">

        Vue.component('social-register', {
            data: function () {
                return {
                    count: 0
                }
            },
            methods: {
                validateBeforeSubmit() {
                    this.$validator.validateAll().then((result) => {
                        console.log('ok');
                    });
                }
            },
            template: '<div id="socialRegister"><slot></slot></div>'
        });
    </script>
@endpush
