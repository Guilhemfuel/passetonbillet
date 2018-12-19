@extends('layouts.dashboard')

@section('dashboard-content')

    <div class="help-page" id="help-age">

        <div class="section-header">
            <div class="first-section">
                <div class="fixed-content">
                    <div class="content">
                        <div>
                            <h2 class="text-center text-white mt-5">@lang('faq.title')</h2>

                            <help></help>
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
