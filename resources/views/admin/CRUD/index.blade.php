@extends('admin.layouts.app')


@section('admin-title')
    - {{ucfirst($model)}}
@endsection

@section('admin-content')

    <div class="crud-table" id="crud-table">

        <div class="card">
            <div class="card-header">
                <h5>{{ucfirst($model)}}</h5>
                {!!isset($search)?'<a href='.route($model.'.index').'>Cancel search</a>':''!!}
            </div>

            <div class="card-body pt-0">
                <div class="crud-actions">
                    @if($creatable)
                        <a href="{{route($model.'.create')}}" class="btn btn-success btn-fill btn-sm"><i
                                    class="fa fa-plus"></i> Add new</a>
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
                                    <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i></button>
                                </span>
                            </div>
                        </form>
                    </div>
                @else
                    <div class="no-crud-search"></div>
                @endif

                <div class="crud-actions">
                    @if($creatable)
                        <a href="{{route($model.'.create')}}" class="btn btn-success btn-fill btn-sm"><i
                                    class="fa fa-plus"></i> Add new</a>
                    @endif
                </div>

                @if($paginable)
                    <div class="top-pagination">
                        @if(isset($search))
                            {{ $entities->appends(['search' => $search])->links() }}
                        @else
                            {{ $entities->links() }}

                        @endif
                    </div>
                @endif

                <div class="table-responsive table-full-width">
                    @include('admin.CRUD.'. $model .'.table')
                </div>

                @if($paginable)
                    <div class="bottom-pagination">
                        @if(isset($search))
                            {{ $entities->appends(['search' => $search])->links() }}
                        @else
                            {{ $entities->links() }}
                        @endif
                    </div>
                @endif

            </div>
        </div>
    </div>

@endsection
