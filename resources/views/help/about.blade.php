@extends('layouts.dashboard')

@section('dashboard-content')

    <div class="cgu-page">

        <div class="section-header">
            <div class="first-section">
                <div class="fixed-content">
                    <div class="content">
                        <div>
                            <h2 class="text-center text-white mt-3">@lang('about.title')</h2>

                            <div class="container container-over-bg p-5 mt-5 text-justify">

                                <h2 class="text-center">@lang('about.sub_title')</h2>

                                <div class="section mt-5">
                                    <h4 class="text-primary text-center">@lang('about.safer.title')</h4>
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-12 col-md-4 d-flex justify-content-center align-content-center">
                                                <img class="d-block d-md-none"
                                                     src="{{secure_asset('img/icon-safe.svg')}}"
                                                     alt="Icon safer"
                                                     style="width: 150px;"
                                                />
                                                <img class="d-none d-md-block"
                                                     src="{{secure_asset('img/icon-safe.svg')}}"
                                                     alt="Icon safer"
                                                     style="width: 60%;"
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
                                                <img class="d-block d-md-none"
                                                     src="{{secure_asset('img/icon-quick.svg')}}"
                                                     alt="Icon quicker"
                                                     style="width: 150px;"
                                                />
                                                <img class="d-none d-md-block"
                                                     src="{{secure_asset('img/icon-quick.svg')}}"
                                                     alt="Icon quicker"
                                                     style="width: 60%;"
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
                                                <img class="d-block d-md-none"
                                                     src="{{secure_asset('img/icon-cheaper.svg')}}"
                                                     alt="Icon cheaper"
                                                     style="width: 150px;"
                                                />
                                                <img class="d-none d-md-block"
                                                     src="{{secure_asset('img/icon-cheaper.svg')}}"
                                                     alt="Icon cheaper"
                                                     style="width: 60%;"
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
