
<li class="{{ Route::currentRouteName() == 'admin.home'? 'active':'' }}">
    <a href="{{route('admin.home')}}">
        <i class="fa fa-home"></i>
        Dashboard
    </a>
</li>

<li  class="{{ substr(Route::currentRouteName(),0,6) == 'users.'? 'active':'' }}">
    <a href="{{route('users.index')}}">
        <i class="fa fa-user-circle-o"></i>
        Users
    </a>
</li>

<li  class="{{ substr(Route::currentRouteName(),0,8) == 'tickets.'? 'active':'' }}">
    <a href="{{route('tickets.index')}}">
        <i class="fa fa-ticket"></i>
        Tickets
    </a>
</li>

<li  class="{{ substr(Route::currentRouteName(),0,9) == 'stations.'? 'active':'' }}">
    <a href="{{route('stations.index')}}">
        <i class="fa fa-globe"></i>
        Stations
    </a>
</li>

<li  class="{{  substr(Route::currentRouteName(),0,7) == 'trains.'? 'active':'' }}">
    <a href="{{route('trains.index')}}">
        <i class="fa fa-train"></i>
        Trains
    </a>
</li>

<?php
    $awaitingIdCheck = \App\Models\Verification\IdVerification::awaitingCount();
?>

<li  class="{{substr(Route::currentRouteName(),0,9) == 'id_check.'? 'active':'' }}">
    <a href="{{route('id_check.oldest')}}">
        <i class="fa fa-id-card-o"></i>
        ID Check @if($awaitingIdCheck>0)<span class="badge badge-pill badge-light">{{$awaitingIdCheck}}</span>@endif
    </a>
</li>