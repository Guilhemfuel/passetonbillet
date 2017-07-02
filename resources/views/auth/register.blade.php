@extends('layouts.app')

@section('title')
    - @lang('auth.register.title')
@endsection

@section('content')

    <div id="section_register">
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 col-xs-10 col-xs-offset-1">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <h2 class="text-center register-headline">@lang('auth.register.title')</h2>
                                <form role="form"
                                      method="POST"
                                      action="{{ route('register') }}"
                                      data-toggle="validator">
                                    {{ csrf_field() }}

                                    <div class="col-xs-12 form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                                        <label for="first_name"
                                               class="control-label">@lang('auth.register.first_name')</label>

                                        <input id="first_name" type="text" class="form-control" name="first_name"
                                               value="{{ old('first_name') }}" required autofocus
                                               placeholder="@lang('auth.register.first_name')"
                                        >

                                        @if ($errors->has('first_name'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('first_name') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="col-xs-12 form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                                        <label for="last_name"
                                               class="control-label">@lang('auth.register.last_name')</label>

                                        <input id="last_name" type="text" class="form-control" name="last_name"
                                               value="{{ old('last_name') }}" required autofocus
                                               placeholder="@lang('auth.register.last_name')">

                                        @if ($errors->has('last_name'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('last_name') }} </strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="col-xs-12 form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                        <label for="email" class="control-label">@lang('auth.register.email')</label>

                                        <input id="email" type="email" class="form-control" name="email"
                                               value="{{ old('email') }}" required
                                               placeholder="@lang('auth.register.email')">

                                        @if ($errors->has('email'))
                                            <span class="help-block">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                        @endif

                                    </div>

                                    <div class="col-xs-12 form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                        <label for="password" class="control-label">@lang('auth.register.password')
                                            <span class="help-label">(8 char. min)</span></label>

                                        <input id="password" type="password" class="form-control" name="password"
                                               required placeholder="@lang('auth.register.password')">

                                        @if ($errors->has('password'))
                                            <span class="help-block">
                                                    <strong>{{ $errors->first('password') }}</strong>
                                                </span>
                                        @endif
                                    </div>

                                    <div class="col-xs-12 form-group">
                                        <label for="password-confirm"
                                               class="control-label">@lang('auth.register.password_confirm') <span
                                                    class="help-label">(8 char. min)</span></label>

                                        <input id="password-confirm" type="password" class="form-control"
                                               name="password_confirmation" required placeholder="@lang('auth.register.password')">
                                    </div>

                                    {{-- TODO: Accept rules checkbox + Captcha --}}

                                    <button type="submit" class="btn btn-info center-block">
                                        Register
                                    </button>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
