<li class="nav-item nav-logged-part">
    <a class="user-picture" href="{{route('public.profile.home')}}">
        <img class="mx-auto rounded-circle img-fluid" src="{{$user->picture}}" alt="profile_picture"/>
    </a>
    <a class="user-first-name d-none d-md-flex" href="{{route('public.profile.home')}}">
        <p>{{$user->first_name}}</p>
    </a>

    <dropdown-menu>
    </dropdown-menu>
    <notifications :current-page="currentPage" :user="user" v-cloak></notifications>
</li>