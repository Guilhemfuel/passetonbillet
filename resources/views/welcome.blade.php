@extends('layouts.app')


@section('content')

    <section id="section_header">

        <div class="header-content">
            <h1 class="header-title">{{config('app.name')}}</h1>
            <div class="center-block header-buttons">
                <button class="btn btn-lastar-outline">@lang('common.button.buy')</button>
                <button class="btn btn-lastar-outline">@lang('common.button.sell')</button>
            </div>
        </div>


    </section>

    <section id="section_buy">

    </section>

    <section id="section_sell">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-12 col-md-offset-3">

                </div>
            </div>
        </div>
    </section>

@endsection