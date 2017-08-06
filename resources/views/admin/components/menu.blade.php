
<li {{ $model == "" ? 'class=active' : '' }}>
    <a href="{{route('admin.home')}}">
        <i class="fa fa-home"></i>
        <p>Dashboard</p>
    </a>
</li>

<li {{ $model == "users" ? 'class=active' : '' }}>
    <a href="{{route('users.index')}}">
        <i class="fa fa-user-circle-o"></i>
        <p>Users</p>
    </a>
</li>

<li {{ $model == "tickets" ? 'class=active' : '' }}>
    <a href="{{route('tickets.index')}}">
        <i class="fa fa-ticket"></i>
        <p>Tickets</p>
    </a>
</li>

<li {{ $model == "stations" ? 'class=active' : '' }}>
    <a href="{{route('stations.index')}}">
        <i class="fa fa-globe"></i>
        <p>Stations</p>
    </a>
</li>

<li {{ $model == "trains" ? 'class=active' : '' }}>
    <a href="{{route('trains.index')}}">
        <i class="fa fa-train"></i>
        <p>Trains</p>
    </a>
</li>