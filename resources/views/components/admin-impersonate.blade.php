@if(\Cookie::has(\App\Http\Controllers\Admin\UserController::ADMIN_IMPERSONATE_COOKIE_NAME))
    <div class="admin-impersonate">
        <a href="{{route('public.reverse_impersonate')}}" class="text-center">Back to Admin</a>
    </div>
@endif