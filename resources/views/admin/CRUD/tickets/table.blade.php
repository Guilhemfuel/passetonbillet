
    @if(count($entities)>0)

    <table class="table table-hover table-striped">
        <thead>
        <th>Seller Email</th>
        <th>Date</th>
        <th>From</th>
        <th>To</th>
        <th>Price</th>
        <th>Actions</th>
        </thead>
        <tbody>
        @foreach($entities as $entity)
            <tr>
                <td>
                    <a href="{{route('users.edit',$entity->user->id)}}">{{$entity->user->full_name}}</a>
                    <span class="text-danger pull-right">{{$entity->eurostar_ticket_number==null?'FAKE':''}}</span>
                </td>
                <td>
                    {{$entity->train->carbon_departure_date->format('d/m/Y')  }}
                </td>
                <td>
                    {{substr($entity->train->departureCity->short_name,2)}}
                </td>
                <td>
                    {{ substr($entity->train->arrivalCity->short_name,2)  }}
                </td>
                <td>{{$entity->price}} {{$entity->currency}}</td>
                <td>
                    <a class="btn btn-sm btn-info btn-fill" href="{{route('tickets.edit',$entity->id)}}">
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
