@if(App::environment()!='production')
<p>For test only (not available in prod):
    <a class="btn btn-warning" href="{{route('claims.make-transfer')}}">Make Transfers</a>
</p>
@endif

<claims-table :claims="child.claims"></claims-table>

@push('vue-data')
    <script type="application/javascript">
      data.claims = {!! json_encode($entities) !!};
    </script>
@endpush
