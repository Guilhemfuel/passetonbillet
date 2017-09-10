@extends('admin.layouts.app')


@section('title')
    - {{ucfirst($model)}}
@endsection

@section('content')

    <div class="crud-table" id="crud-table">

        <div class="card">
            <div class="card-header">
                {{ucfirst($model)}}  {!!isset($search)?'- <a href='.route($model.'.index').'>Cancel search</a>':''!!}
                <span class="pull-right"></span>
            </div>

            <div class="card-body">
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
                            <button class="btn btn-default" type="button"><i class="fa fa-search"></i></button>
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
            </div>
        </div>
    </div>

@endsection


@push('scripts')
    <script type="application/javascript">
        const tableIndex = new Vue({
            el: '#crud-table'
        });
    </script>
@endpush