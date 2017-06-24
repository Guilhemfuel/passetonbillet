@extends('layouts.app')


@section('content')

    <div id="section_header">

        <div class="header-content">
            <h1 class="header-title">Lastar.io</h1>
            <p class="header-subtitle">
                @lang('common.catchline')
            </p>
            <div class="center-block header-buttons">
                <button class="btn btn-lastar-outline">@lang('common.button.buy')</button>
                <button class="btn btn-lastar-outline">@lang('common.button.sell')</button>
            </div>
        </div>

    </div>

@endsection