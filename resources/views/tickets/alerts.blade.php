@extends('layouts.dashboard')

@section('title')
    - My Alerts
@endsection

@section('dashboard-content')
    <div class="container">
        <div class="row" id="manage-alerts">
            <my-alerts :default-alerts="child.my_alerts.alerts"></my-alerts>
        </div>
    </div>
@endsection

@push('vue-data')


    <script type="text/javascript">
        data.my_alerts = {
            alerts: {!! $alerts ? json_encode($alerts) : '[]'!!}
        }
    </script>
@endpush