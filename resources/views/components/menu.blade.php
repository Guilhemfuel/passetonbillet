<li  class="{{ Route::current()->getName() == 'public.ticket.buy.page' ? ' active' : '' }}">
    <a href="{{route('public.ticket.buy.page')}}">
        <i class="fa fa-shopping-cart" aria-hidden="true"></i>
        <span class="d-sm-inline d-none label">{{__('nav.buy_ticket')}}</span>
    </a>
</li>

<li  class="{{ Route::current()->getName() == 'public.ticket.sell.page' ? ' active' : '' }}">
    <a href="{{route('public.ticket.sell.page')}}">
        <i class="fa fa-money"></i>
        <span class="d-sm-inline d-none label">{{__('nav.sell_ticket')}}</span>
    </a>
</li>

<li class="{{ Route::current()->getName() == 'public.message.home.page' ? ' active' : '' }}
    {{ Route::current()->getName() == 'public.message.discussion.page' ? ' active' : '' }}">
    <a href="{{route('public.message.home.page')}}">
        @if($user->count_unread_messages>0)
            <span class="badge badge-pill">{{$user->count_unread_messages}}</span>
        @endif
        <i class="fa fa-envelope-o" aria-hidden="true"></i>
        <span class="d-sm-inline d-none label">{{__('nav.messages')}}</span>
    </a>
</li>


<li  class="{{ Route::current()->getName() == 'public.ticket.owned.page' ? ' active' : '' }}">
    <a href="{{route('public.ticket.owned.page')}}">
        <i class="fa fa-ticket" aria-hidden="true"></i>
        <span class="d-sm-inline d-none label">{{__('nav.my_tickets')}}</span>
    </a>
</li>

<li  class="{{ Route::current()->getName() == 'public.profile.home' ? ' active' : '' }}">
    <a href="{{route('public.profile.home')}}">
        <i class="fa fa-user-circle-o" aria-hidden="true"></i>
        <span class="d-sm-inline d-none label">{{__('nav.my_profile')}}</span>
    </a>
</li>

