
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

<li  class="{{  substr(Route::currentRouteName(),0,7) == 'offers.'? 'active':'' }}">
    <a href="{{route('offers.index')}}">
        <i class="fa fa-comments"></i>
        Offers
    </a>
</li>


<li  class="{{ substr(Route::currentRouteName(),0,6) == 'stats.'? 'active':'' }}">
    <a href="{{route('stats.index')}}">
        <i class="fa fa-bar-chart"></i>
        Stats
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

<?php
    $awaitingWarning = \App\Models\AdminWarning::awaitingCount();
?>

<li  class="{{substr(Route::currentRouteName(),0,9) == 'warnings.'? 'active':'' }}">
    <a href="{{route('warnings.index')}}">
        <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
        Warnings @if($awaitingWarning>0)<span class="badge badge-pill badge-light">{{$awaitingWarning}}</span>@endif
    </a>
</li>


<li  class="{{substr(Route::currentRouteName(),0,5) == 'logs.'? 'active':'' }}">
    <a href="{{route('logs.index')}}">
        <i class="fa fa-terminal"></i>
        Logs
    </a>
</li>

<li  class="{{substr(Route::currentRouteName(),0,11) == 'eyeWitness.'? 'active':'' }}">
    <a href="/eyewitness">
        <i class="fa fa-eye"></i>
        Eye witness
    </a>
</li>


