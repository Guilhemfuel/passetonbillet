@extends('layouts.dashboard')

@section('title')
    - My Tickets sold
@endsection

@section('dashboard-content')
    <div class="container">
        <div class="row">
            <my-tickets-sold></my-tickets-sold>
        </div>
    </div>
@endsection

@push('vue-data')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.3.200/pdf.min.js" integrity="sha256-J4Z8Fhj2MITUakMQatkqOVdtqodUlwHtQ/ey6fSsudE=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.3.200/pdf.worker.js" integrity="sha256-dJSOqtDrNjfG3bC2bSZAHCZgE4zQT0Js6brOkFp8PE8=" crossorigin="anonymous"></script>

    <script type="text/javascript">

    </script>
@endpush