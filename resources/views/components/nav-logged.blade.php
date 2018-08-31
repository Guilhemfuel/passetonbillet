<dropdown-menu v-cloak>
    <div class="d-flex">
        <div class="user-picture">
            <img class="mx-auto rounded-circle img-fluid nav-picture" src="{{Auth::user()->picture}}"
                 alt="profile_picture"/>
        </div>
        <div class="user-first-name d-none d-md-flex">
            <p>{{Auth::user()->first_name}}
                <i class="fa fa-caret-down" aria-hidden="true"></i>
            </p>
        </div>
        <p class="d-inline d-md-none caret-small">
            <i class="fa fa-caret-down " aria-hidden="true"></i>
        </p>

    </div>

</dropdown-menu>

<li class="nav-item nav-logged-part">
    <notifications :current-page="currentPage" :user="user" v-cloak></notifications>
</li>