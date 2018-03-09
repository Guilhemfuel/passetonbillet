@extends('layouts.app')

@section('content')

    <div class="contact-page" id="contact-page">

        <div class="section-header">
            <div class="first-section" style="background-image: url('{{asset('img/bg/3.jpg')}}');">
                <div class="fixed-content">
                    <nav class="navbar">
                        <a class="navbar-brand" href="{{route('home')}}">
                            <img src="{{asset('img/logo.png')}}" class="d-inline-block align-top" alt="logo lastar">
                        </a>
                        <ul class="navbar-nav navbar-expand">
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('login')}}">@lang('nav.login')</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('register')}}">@lang('nav.register')</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" onclick="$crisp.push(['do', 'chat:open'])">
                                    <i class="fa fa-question-circle" aria-hidden="true"></i>
                                </a>
                            </li>
                            @if (App::isLocale('fr'))
                                <a class="nav-link" href="{{route('lang','en')}}">
                                    <span class="flag-icon flag-icon-fr"></span>
                                </a>
                            @else
                                <a class="nav-link" href="{{route('lang','fr')}}">
                                    <span class="flag-icon flag-icon-gb"></span>
                                </a>
                            @endif
                        </ul>
                    </nav>
                    <div class="content">
                        <div class="center">
                            <h1 class="text-center text-white">CONTACT</h1>
                            <div class="row justify-content-center">
                                <div class="col-12 col-sm-8">
                                <form class="mt-3 p-2" action="{{route('contact')}}" method="POST">
                                    {{csrf_field()}}
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <input type="text" class="form-control" placeholder="Your name" required name="name">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <input type="email" class="form-control" placeholder="Your email" required name="email">
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-group">
                                                <textarea type="text" class="form-control"
                                                          placeholder="Your message" required name="message"></textarea>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-group ">
                                                <div class="mx-auto" style="width: 304px;">
                                                    {!! NoCaptcha::display() !!}
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-12">
                                            <div class="text-center mx-auto" style="width: 304px;">
                                                <button type="submit" class="btn btn-lastar-blue btn-block">Send</button>
                                            </div>
                                        </div>

                                    </div>
                                </form>
                            </div>
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
