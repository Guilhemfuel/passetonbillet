@extends('layouts.app')

@section('title')
    - Admin - Page Builder
@endsection

@section('main_css_file')
    <link rel="stylesheet" href="{{ mix('/css/admin.css') }}">
@endsection

@section('main_js_file')
    <script src="{{mix('/js/admin.js')}}"></script>
@endsection

@section('content')

    <div id="unique-page-builder">
        <div class="card main-card">
            <div class="card-header">
                <div class="row">
                    <div class="col">
                        <h4>Pages</h4>
                    </div>
                    <div class="col">
                        <p class="text-right">
                            Back to admin
                        </p>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <page-builder css-file="{{ mix('/css/app.css') }}" :js-files="['{{mix('/js/manifest.js')}}','{{mix('/js/vendor.js')}}','{{ mix('/js/lang/lang-'.\App::getLocale().'.js')}}','{{mix('/js/app.js')}}']"></page-builder>
            </div>
        </div>
    </div>

@endsection
