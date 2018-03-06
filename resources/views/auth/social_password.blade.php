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
            @if( (null !==(session('flash_notification')) && count(session('flash_notification'))>0) || (isset($errors) && count($errors)>0))
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

                <div id="socialRegister">
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
                            <label for="password" class="control-label">@lang('profile.modal.change_password.component.password')
                                <small class="text-muted">(8 char. min)</small>
                            </label>
                            <input id="password" type="password"
                                   class="form-control"
                                   name="password"
                                   required placeholder="@lang('profile.modal.change_password.component.password')">

                        </div>

                        <div class="col-xs-12 form-group">
                            <label for="password-confirm"
                                   class="control-label">@lang('profile.modal.change_password.component.password_confirm')</label>

                            <input id="password-confirm" type="password"
                                   class="form-control"
                                   name="password_confirmation"
                                   required placeholder="@lang('profile.modal.change_password.component.password_confirm')">
                        </div>

                        <div class="form-group mt-4">
                            <div class="col-xs-12">
                                <button type="submit" class="btn btn-lastar-blue btn-block">
                                    @lang('auth.register.title')
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    @if((null !==(session('flash_notification')) && count(session('flash_notification'))>0) || (isset($errors) && count($errors)>0))
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
