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
                                <p>{!! __('about.text')  !!}</p>

                                <p><b>@lang('about.timeline.title')</b></p>
                                <ul>
                                    @foreach(__('about.timeline.points') as $point)
                                        <li>{!! $point !!}</li>
                                    @endforeach
                                </ul>


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
