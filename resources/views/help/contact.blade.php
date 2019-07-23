@extends('layouts.dashboard')

@section('dashboard-content')

    <div class="contact-page" id="contact-page">

        <div class="section-header">
            <div class="first-section">
                <div class="fixed-content">
                    <div class="content">
                        <div class="center container-fluid">
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
                                                <button type="submit" class="btn btn-ptb-blue btn-block">Send</button>
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
