
    <tickets-table :tickets="child.tickets" :stations="child.stations"></tickets-table>

    @push('vue-data')
    <script type="application/javascript">
        data.tickets = {!! json_encode($entities) !!};
        data.stations = {!! json_encode($stations) !!};
    </script>
@endpush
