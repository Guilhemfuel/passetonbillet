@extends('layouts.app')

@section('title')
    - @lang('auth.auth.title')
@endsection

@section('content')

    <div id="section_login">
        <div class="content container">
            <div class="row">
                <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 col-xs-10 col-xs-offset-1">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <h2 class="text-center login-headline">@lang('auth.auth.title')</h2>
                            <form role="form"
                                  method="POST"
                                  action="{{ route('login') }}"
                                  data-toggle="validator">
                                {{ csrf_field() }}

                                <div class="col-xs-12 form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label for="email" class="control-label">@lang('auth.auth.email')</label>

                                    <input id="email" type="email" class="form-control" name="email"
                                           value="{{ old('email') }}" required autofocus>

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="col-xs-12 form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label for="password" class="control-label">@lang('auth.auth.password')</label>

                                    <input id="password" type="password" class="form-control" name="password"
                                           required>

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox"
                                                       name="remember" {{ old('remember') ? 'checked' : '' }}>
                                                @lang('auth.auth.remember_me')
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <button type="submit" class="btn btn-info center-block">
                                            Login
                                        </button>

                                        {{-- TODO: Password reset --}}
                                        {{--<a class="btn btn-link" href="{{ route('password.page') }}">--}}
                                        {{--Forgot Your Password?--}}
                                        {{--</a>--}}
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
