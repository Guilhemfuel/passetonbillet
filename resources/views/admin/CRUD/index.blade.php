@extends('admin.layouts.app')


@section('title')
    - {{ucfirst($model)}}
@endsection

@section('content')

    <div class="crud-table">
    @component('admin.components.card')
        @section('card-title')
            {{ucfirst($model)}}
        @endsection

        @section('card-category')
            {!!isset($search)?'<a href='.route($model.'.index').'>Cancel search</a>':''!!}
        @endsection

        @section('card-body')

            <div class="crud-actions">
                @if($creatable)
                    <a href="{{route($model.'.create')}}" class="btn btn-success btn-fill btn-sm"><i class="fa fa-plus"></i> Add new</a>
                @endif
            </div>

            @if($searchable)
            <div class="crud-search">
                <form method="get">
                    <div class="input-group input-group-sm">
                        <input type="text"
                               class="form-control"
                               placeholder="Search for..."
                               name="search"
                                {{isset($search)?'value='.$search:''}}

                        >
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button"><i class="fa fa-search"></i></button>
                        </span>
                    </div>
                </form>
            </div>
            @else
                <div class="no-crud-search"></div>
            @endif

            <div class="top-pagination">
                @if(isset($search))
                    {{ $entities->appends(['search' => $search])->links() }}
                @else
                    {{ $entities->links() }}

                @endif
            </div>

            <div class="table-responsive table-full-width">
                @include('admin.CRUD.'. $model .'.table')
            </div>

            <div class="bottom-pagination">
                @if(isset($search))
                    {{ $entities->appends(['search' => $search])->links() }}
                @else
                    {{ $entities->links() }}
                @endif
            </div>


        @endsection
    @endcomponent
    </div>

@endsection