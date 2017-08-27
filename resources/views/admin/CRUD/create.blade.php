@extends('admin.layouts.app')


@section('title')
    - Create {{$entitySingleName}}
@endsection

@section('content')

    <div class="crud-table">
    @component('admin.components.card')
        @section('card-title')
            Create new {{$entitySingleName}}
        @endsection

        @section('card-category')
            {!!'<a href='.route($model.'.index').'>Back to '.$model.' list</a>'!!}
        @endsection

        @section('card-body')

            <form id="createForm" method="POST" action="{{route($model.'.store')}}">
                {{csrf_field()}}

                @include('admin.CRUD.'.$model.'.form')

                <div class="crud-form-bottom">
                    <button class="btn btn-success btn-fill" type="submit">
                        <i class="fa fa-plus"></i> Create new entity
                    </button>
                </div>
            </form>

        @endsection
    @endcomponent
    </div>

@endsection

@push('scripts')
    <script type="application/javascript">
        const createForm = new Vue({
            el: '#createForm',
            data: {
                inputClass: 'form-control'
            }
        });
    </script>
@endpush