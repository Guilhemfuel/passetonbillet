@extends('admin.CRUD.index')

@section('table')

    <table class="table table-hover table-striped">
        <thead>
        <th>Name</th>
        <th class="text-center">Shortname</th>
        <th class="text-center">Eurostar ID</th>
        <th class="text-center">Country</th>
        <th>Actions</th>
        </thead>
        <tbody>
        @foreach($entities as $entity)
            <tr>
                <td>{{$entity->name_en}}</td>
                <td class="text-center">{{$entity->short_name}}</td>
                <td class="text-center">{{$entity->eurostar_id}}</td>
                <td class="text-center">{!!$entity->flag!!}</td>
                <td>
                    <a class="btn btn-sm btn-info btn-fill" href="{{route('stations.edit',$entity->id)}}">
                        <i class="fa fa-pencil" aria-hidden="true"></i>
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection