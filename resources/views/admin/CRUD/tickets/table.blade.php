
    @if(count($entities)>0)

    {{-- TODO: links to trains and users--}}

    <table class="table table-hover table-striped">
        <thead>
        <th>Buyer Name</th>
        <th>Buyer Email</th>
        <th>Train ID</th>
        <th>Price</th>
        <th>Currency</th>
        <th>Actions</th>
        </thead>
        <tbody>
        @foreach($entities as $entity)
            <tr>
                <td>{{$entity->buyer_name}}</td>
                <td>{{$entity->buyer_email}}</td>
                <td>{{$entity->train->number}}</td>
                <td>{{$entity->price}}</td>
                <td>{{$entity->currency}}</td>
                <td>
                    <a class="btn btn-sm btn-info btn-fill" href="{{route('tickets.show',$entity->id)}}">
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
