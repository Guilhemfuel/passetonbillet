
    @if(count($entities)>0)

        <table class="table table-hover table-striped">
            <thead>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Status</th>
            <th>Actions</th>
            </thead>
            <tbody>
            @foreach($entities as $entity)
                <tr>
                    <td>{{$entity->first_name}}</td>
                    <td>{{$entity->last_name}}</td>
                    <td>{{$entity->role}}</td>
                    <td>
                        <a class="btn btn-sm btn-info btn-fill" href="{{route('users.show',$entity->id)}}">
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
