@extends('admin.layouts.app')


@section('title')
    - Edit {{$entitySingleName}}
@endsection

@section('content')

    <div class="crud-table">

        <div class="card">

            <div class="card-header">
                Edit {{$entitySingleName}} - {!!'<a href='.route($model.'.index').'>Back to '.$model.' list</a>'!!}
            </div>

            <div class="card-body">
                @if(isset($entity))
                    <div class="crud-actions">
                        <form id="deleteForm" method="POST" action="{{route($model.'.destroy',$entity->id)}}">
                            {{csrf_field()}}
                            {{ method_field('DELETE') }}
                        </form>
                        <button class="btn btn-danger btn-fill btn-sm" id="btn-delete"><i class="fa fa-trash" data-toggle="modal" data-target="#deleteModal"></i> Delete entity</button>
                    </div>
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
            el: '#editForm',
            data: {
                inputClass: 'form-control'
            }
        });

        $(document).ready(function(){
            $('#btn-delete').click(function(){
                swal({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    confirmButtonClass: 'btn btn-danger btn-fill btn-margin',
                    cancelButtonClass: 'btn btn-default btn-fill btn-margin',
                    buttonsStyling: false

                }).then(function () {
                    $('#deleteForm').submit();
                }).catch(swal.noop);
            });
        });
    </script>
@endpush