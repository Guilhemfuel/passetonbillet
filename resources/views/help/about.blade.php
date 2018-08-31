@extends('layouts.app')

@section('content')

    <div class="cgu-page">

        <div class="section-header">
            <div class="first-section" style="background-image: url('{{secure_asset('img/bg/3.jpg')}}');">
                <div class="fixed-content">
                    <nav class="navbar">
                        <a class="navbar-brand" href="{{route('home')}}">
                            <img src="{{secure_asset('img/logo.png')}}" class="d-inline-block align-top" alt="logo ptb">
                        </a>
                        <ul class="navbar-nav navbar-expand">
                            @if(!Auth::check())
                                <li class="nav-item">
                                    <a class="nav-link" href="{{route('login')}}">@lang('nav.login')</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{route('register')}}">@lang('nav.register')</a>
                                </li>
                            @endif
                            <li class="nav-item">
                                <a class="nav-link" href="#" onclick="$crisp.push(['do', 'chat:open'])">
                                    <i class="fa fa-question-circle" aria-hidden="true"></i>
                                </a>
                            </li>
                            @if (App::isLocale('fr'))
                                <a class="nav-link" href="{{route('lang','en')}}">
                                    <span class="flag-icon flag-icon-gb"></span>
                                </a>
                            @else
                                <a class="nav-link" href="{{route('lang','fr')}}">
                                    <span class="flag-icon flag-icon-fr"></span>
                                </a>
                            @endif
                        </ul>
                    </nav>
                    <div class="content">
                        <div>
                            <h2 class="text-center text-white">@lang('about.title')</h2>

                            <div class="container container-over-bg p-5 mt-5 text-justify">

                                <h2 class="text-center">@lang('about.sub_title')</h2>

                                <div class="section mt-5">
                                    <h4 class="text-primary text-center">@lang('about.safer.title')</h4>
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-12 col-md-4 d-flex justify-content-center align-content-center">
                                                <img class="d-sm-block d-md-none"
                                                     src="{{secure_asset('img/icon-safe.svg')}}"
                                                     alt="Icon safer"
                                                     style="width: 150px;"
                                                />
                                                <img class="d-md-block d-sm-none"
                                                     src="{{secure_asset('img/icon-safe.svg')}}"
                                                     alt="Icon safer"
                                                     style="width: 80%;"
                                                />
                                            </div>
                                            <div class="col-12 col-md-8">
                                                <ul>
                                                    @foreach(__('about.safer.content') as $line)
                                                        <li>{{$line}}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="section mt-5">
                                    <h4 class="text-primary text-center">@lang('about.quicker.title')</h4>
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-12 col-md-8">
                                                <ul>
                                                    @foreach(__('about.quicker.content') as $line)
                                                        <li>{{$line}}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                            <div class="col-12 col-md-4 d-flex justify-content-center align-content-center">
                                                <img class="d-sm-block d-md-none"
                                                     src="{{secure_asset('img/icon-quick.svg')}}"
                                                     alt="Icon quicker"
                                                     style="width: 150px;"
                                                />
                                                <img class="d-md-block d-sm-none"
                                                     src="{{secure_asset('img/icon-quick.svg')}}"
                                                     alt="Icon quicker"
                                                     style="width: 80%;"
                                                />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="section mt-5">
                                    <h4 class="text-primary text-center">@lang('about.cheaper.title')</h4>
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-12 col-md-4 d-flex justify-content-center align-content-center">
                                                <img class="d-sm-block d-md-none"
                                                     src="{{secure_asset('img/icon-cheaper.svg')}}"
                                                     alt="Icon cheaper"
                                                     style="width: 150px;"
                                                />
                                                <img class="d-md-block d-sm-none"
                                                     src="{{secure_asset('img/icon-cheaper.svg')}}"
                                                     alt="Icon cheaper"
                                                     style="width: 80%;"
                                                />
                                            </div>
                                            <div class="col-12 col-md-8">
                                                <ul>
                                                    @foreach(__('about.cheaper.content') as $line)
                                                        <li>{{$line}}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <p class="text-primary font-weight-bold text-center mt-5">
                                    @lang('common.help.before_icon') <img class="d-inline px-2" src="{{secure_asset('img/icones/crisp.png')}}"> @lang('common.help.after_icon')
                                </p>

                            </div>
                        </div>
                    </div>
                </div>
            </div>


            @include('components.footer')
        </div>

    </div>

@endsection

@push('scripts')
    {!! \Anhskohbo\NoCaptcha\Facades\NoCaptcha::renderJs(App::getLocale()) !!}

@endpush
