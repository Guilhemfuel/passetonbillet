
    @if(count($entities)>0)

        <table class="table table-hover table-striped">
            <thead>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Status</th>
            <th class="text-center">Phone</th>
            <th class="text-center">Facebook</th>
            <th class="text-center">Verified</th>
            <th>Actions</th>
            </thead>
            <tbody>
            @foreach($entities as $entity)
                <tr>
                    <td>{{$entity->first_name}}</td>
                    <td>{{$entity->last_name}}</td>
                    <td>{{$entity->role}}</td>
                    <td class="text-center">
                        @if($entity->phone_verified)
                            <i class="fa fa-phone-square text-success" aria-hidden="true"></i>
                        @else
                            X
                        @endif
                    </td>
                    <td class="text-center">{!!$entity->fb_id!=null?'<a href="https://facebook.com/'.$entity->fb_id.'" target="_blank"><i aria-hidden="true" class="fa fa-facebook-official text-facebook"></i></a>':'X'!!}</td>
                    <td class="text-center">{!!$entity->id_verified?'<i aria-hidden="true" class="fa fa-check-circle text-warning"></i>':'X'!!}</td>
                    <td>
                        <a class="btn btn-sm btn-info btn-fill" href="{{route('users.edit',$entity->id)}}">
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
