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
                        <button class="btn btn-danger btn-fill btn-sm" id="btn-delete" @click="deleteModalOpened = true">
                            <i class="fa fa-trash" data-toggle="modal" data-target="#deleteModal"></i> Delete entity
                        </button>
                    </div>

                    <modal :is-open="deleteModalOpened" v-on:close-modal="deleteModalOpened = false">
                        Do you really wish to delete this item ?
                        <div>
                            <button class="btn btn-default" @click="deleteModalOpened = false">Cancel</button>
                            <form id="deleteForm" method="POST" action="{{route($model.'.destroy',$entity->id)}}">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button class="btn btn-danger" type="submit">Delete</button>
                            </form>
                        </div>
                    </modal>
                @endif
                    <form id="editForm" method="POST" action="{{route($model.'.update',$entity->id)}}">
                        {{csrf_field()}}
                        {{ method_field('PUT') }}

                        @include('admin.CRUD.'.$model.'.form')

                        <div class="crud-form-bottom">
                            <button class="btn btn-success btn-fill btn-sm" type="submit">
                                <i class="fa fa-floppy-o"></i> Update entity
                            </button>
                        </div>
                    </form>
            </div>

        </div>

    </div>

@endsection

@push('scripts')
    <script type="application/javascript">
        const editForm = new Vue({
            el: '#editPage',
            name: 'EditPage',
            data: {
                inputClass: 'form-control',
                deleteModalOpened: false,
            }
        });
    </script>
@endpush