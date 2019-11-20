<claims-table :claims="child.claims"></claims-table>

@push('vue-data')
    <script type="application/javascript">
      data.claims = {!! json_encode($entities) !!};
    </script>
@endpush
