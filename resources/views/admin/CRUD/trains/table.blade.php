
    @if(count($entities)>0)

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
                <td>
                    <el-tooltip class="item" effect="dark" content="Station details" placement="top-start">
                        <a href="{{route('stations.edit',$entity->departureCity->id)}}">{{$entity->departureCity->name_en?$entity->departureCity->name_en:'-'}}</a>
                    </el-tooltip>
                </td>
                <td>
                    <el-tooltip class="item" effect="dark" content="Station details" placement="top-start">
                        <a href="{{route('stations.edit',$entity->arrivalCity->id)}}">{{$entity->arrivalCity->name_en?$entity->arrivalCity->name_en:'-'}}</a>
                    </el-tooltip>
                </td>
                <td>{{$entity->departure_date?$entity->departure_date:'-'}}</td>
                <td>{{$entity->departure_time?$entity->departure_time:'-'}}</td>
                <td>
                    <a class="btn btn-sm btn-info btn-fill" href="{{route('trains.edit',$entity->id)}}">
                        <i class="fa fa-pencil" aria-hidden="true"></i>
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    @else

        <div class="content">
            0 entity found!
        </div>

    @endif
