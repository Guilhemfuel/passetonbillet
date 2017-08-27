
    @if(count($entities)>0)

    <table class="table table-hover table-striped">
        <thead>
        <th>Seller Email</th>
        <th>Train ID</th>
        <th>Price</th>
        <th>Currency</th>
        <th>Actions</th>
        </thead>
        <tbody>
        @foreach($entities as $entity)
            <tr>
                <td>
                    <el-tooltip class="item" effect="dark" content="{{$entity->user->full_name}}'s profile" placement="top-start">
                        <a href="{{route('users.edit',$entity->user->id)}}">{{$entity->user->email}}</a>
                    </el-tooltip>
                </td>
                <td>
                    <el-tooltip class="item" effect="dark" content="Train details" placement="top-start">
                        <a href="{{route('trains.edit',$entity->train->id)}}">{{$entity->train->number}}</a>
                    </el-tooltip>
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
