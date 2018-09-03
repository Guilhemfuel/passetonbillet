
    <tickets-table :tickets="child.tickets"></tickets-table>

    @push('vue-data')
    <script type="application/javascript">
        data.tickets = {!! json_encode($entities) !!};
    </script>
@endpush
