@extends('admin.CRUD.index')

@section('table')

    <table class="table table-hover table-striped">
        <thead>
        <th>Name</th>
        <th>Shortname</th>
        <th>Eurostar ID</th>
        <th>Country</th>
        <th>Actions</th>
        </thead>
        <tbody>
        @foreach($entities as $entity)
            <tr>
                <td>{{$entity->name_en}}</td>
                <td>{{$entity->short_name}}</td>
                <td>{{$entity->eurostar_id}}</td>
                <td>{{$entity->country}}</td>
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