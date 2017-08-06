@extends('admin.layouts.app')


@section('title')
    - {{ucfirst($model)}}
@endsection

@section('content')

    @component('admin.components.card')
@section('card-title')
    {{ucfirst($model)}}
@endsection

@section('card-category')
    {!!isset($search)?'<a href='.route('users.index').'>Cancel search</a>':''!!}
@endsection

@section('card-body')

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

    <div class="top-pagination">
        @if(isset($search))
            {{ $entities->appends(['search' => $search])->links() }}
        @else
            {{ $entities->links() }}

        @endif
    </div>

    <div class="table-responsive table-full-width">
        @yield('table')
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

@endsection