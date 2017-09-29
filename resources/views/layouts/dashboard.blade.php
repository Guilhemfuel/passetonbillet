@extends('layouts.app')

@section('content')

    @component('components.nav')
    @endcomponent

    <div id="dashboard">
        @if(count(session('flash_notification'))>0 || (isset($errors) && count($errors)>0))
            <!-- Alert Container -->
            <div class="alert-sticky container" id="flash-container">
                <flash v-for="message in messages"
                       v-if="!message.overlay"
                       :type="message.level"
                       :content="message.message"
                       :important="message.important"></flash>
                <flash v-for="error in validationErrors"
                       type="danger"
                       :content="error"
                       :important="true"></flash>
            </div>
        @endif

        @yield('dashboard-content')
    </div>

@endsection

@if(count(session('flash_notification'))>0 || (isset($errors) && count($errors)>0))
    @push('scripts')
        <script type="application/javascript">
            var flashContainer = new Vue({
                el: '#flash-container',
                data: {
                    messages: {!! json_encode(session('flash_notification', collect())->toArray()?:[]) !!},
                    validationErrors: {!! isset($errors)?json_encode($errors->all()):'[]' !!}
                }
            });
        </script>
    @endpush
@endif