
    {{--TODO: add links to station--}}
    <table class="table table-hover table-striped">
        <thead>
        <th>Number</th>
        <th>Departure Station</th>
        <th>Arrival City</th>
        <th>Date</th>
        <th>Time</th>
        <th>Actions</th>
        </thead>
        <tbody>
        @foreach($entities as $entity)
            <tr>
                <td>{{$entity->number?$entity->number:'-'}}</td>
                <td>{{$entity->departureCity->name_en?$entity->departureCity->name_en:'-'}}</td>
                <td>{{$entity->arrivalCity->name_en?$entity->arrivalCity->name_en:'-'}}</td>
                <td>{{$entity->departure_date?$entity->departure_date:'-'}}</td>
                <td>{{$entity->departure_time?$entity->departure_time:'-'}}</td>
                <td>
                    <a class="btn btn-sm btn-info btn-fill" href="{{route('trains.index',$entity->id)}}">
                        <i class="fa fa-pencil" aria-hidden="true"></i>
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
