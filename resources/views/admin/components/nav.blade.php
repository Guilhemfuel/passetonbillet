<nav class="navbar navbar-light navbar-expand-lg">
    <div class="container-fluid">
        <div class="navbar-header">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarAdmin" aria-controls="navbarAdmin" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse" id="navbarAdmin">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Dashboard <span class="sr-only">(current)</span></a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('home')}}">
                        Back to Lastar
                    </a>
                </li>
                <li  class="nav-item">
                    <a class="nav-link" href="{{route('logout')}}">
                        Log out
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
