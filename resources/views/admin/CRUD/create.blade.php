@extends('admin.layouts.app')


@section('title')
    - Create {{$entitySingleName}}
@endsection

@section('content')

    <div class="crud-table">

        <div class="card">
            <div class="card-header">
                Create new {{$entitySingleName}} - {!!'<a href='.route($model.'.index').'>Back to '.$model.' list</a>'!!}
            </div>
            <div class="card-body">
                <form id="createForm" method="POST" action="{{route($model.'.store')}}">
                    {{csrf_field()}}

                    @include('admin.CRUD.'.$model.'.form')

                    <div class="crud-form-bottom">
                        <button class="btn btn-success btn-fill" type="submit">
                            <i class="fa fa-plus"></i> Create new entity
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
