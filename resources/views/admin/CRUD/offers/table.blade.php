
    @if(count($entities)>0)

    <table class="table table-hover table-striped">
        <thead>
        <th class="text-center">Ticket</th>
        <th>Buyer</th>
        <th>Seller</th>
        <th>Status</th>
        <th>Price</th>
        <th>Actions</th>
        </thead>
        <tbody>
        @foreach($entities as $entity)
            @if($entity->ticket)
            <tr>
                <td class="text-center">
                    <a href="{{route('tickets.edit',$entity->ticket->id)}}">
                        <i class="fa fa-ticket"></i>
                    </a>
                </td>
                <td>
                    <a href="{{route('users.edit',$entity->buyer->id)}}">
                        {{$entity->buyer->full_name}}
                    </a>
                </td>
                <td>
                    <a href="{{route('users.edit',$entity->ticket->user->id)}}">
                        {{$entity->ticket->user->full_name}}
                    </a>
                </td>
                <td>
                   {{$entity->status_text}}
                </td>
                <td>{{$entity->price}} {{$entity->currency}}</td>
                <td>
                    <a class="btn btn-sm btn-info btn-fill" href="{{route('offers.edit',$entity->id)}}">
                        <i class="fa fa-pencil" aria-hidden="true"></i>
                    </a>
                </td>
            </tr>
            @endif
        @endforeach
        </tbody>
    </table>

    @else

        <div class="content">
            0 entity found!
        </div>

    @endif
