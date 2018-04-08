
    @if(count($entities)>0)

    <table class="table table-hover table-striped">
        <thead>
        <th>Seller Email</th>
        <th>Date</th>
        <th>Price</th>
        <th>Currency</th>
        <th>Actions</th>
        </thead>
        <tbody>
        @foreach($entities as $entity)
            <tr>
                <td>
                    <a href="{{route('users.edit',$entity->user->id)}}">{{$entity->user->email}}</a>
                    <span class="text-danger pull-right">{{$entity->eurostar_ticket_number==null?'FAKE':''}}</span>
                </td>
                <td>
                    {{$entity->train->departure_date}}
                </td>
                <td>{{$entity->price}}</td>
                <td>{{$entity->currency}}</td>
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
