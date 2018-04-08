@extends('admin.layouts.app')


@section('title')
    - Edit {{$entitySingleName}}
@endsection

@section('content')

    <div class="crud-table">

        <div class="card">

            <div class="card-header">
                <h5>Edit {{$entitySingleName}}</h5>
                {!!'<a href='.route($model.'.index').'>Back to '.$model.' list</a>'!!}
            </div>

            <div class="card-body" id="editPage">

                @if(isset($entity))
                    <div class="crud-actions">
                        <button class="btn btn-danger btn-fill btn-sm" id="btn-delete" @click="child.edit_page.deleteModalOpened = true">
                            <i class="fa fa-trash" data-toggle="modal" data-target="#deleteModal"></i> Delete entity
                        </button>
                    </div>

                    <modal v-cloak :is-open="child.edit_page.deleteModalOpened" v-on:close-modal="child.edit_page.deleteModalOpened = false">
                        Do you really wish to delete this item ?
                        <div>
                            <button class="btn btn-default" @click="child.edit_page.deleteModalOpened = false">Cancel</button>
                            <form id="deleteForm" method="POST" action="{{route($model.'.destroy',$entity->id)}}">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button class="btn btn-danger" type="submit">Delete</button>
                            </form>
                        </div>
                    </modal>
                @endif
                    <form id="editForm" method="POST" action="{{route($model.'.update',$entity->id)}}" v-cloak >
                        {{csrf_field()}}
                        {{ method_field('PUT') }}

                        @include('admin.CRUD.'.$model.'.form')

                        <div class="crud-form-bottom">
                            <button class="btn btn-success btn-fill btn-sm" type="submit">
                                <i class="fa fa-floppy-o"></i> Update entity
                            </button>
{{--                            @include('admin.CRUD.'.$model.'.form')--}}

                        </div>
                    </form>

                @stack('additional-content')
            </div>

        </div>

    </div>

@endsection





@push('vue-data')
    <script type="application/javascript">

        data.edit_page = {
            deleteModalOpened: false,
        }

    </script>
@endpush