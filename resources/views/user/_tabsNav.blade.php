<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link {{ request()->is('user/timeline/*') ? 'active' : '' }}" href="{{ "/user/timeline/" . $user->id }}">@lang('hc.timeline')</a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ request()->is('user/topic/*') ? 'active' : '' }}" href="{{ "/user/topic/" . $user->id }}">@lang('hc.topic')</a>
    </li>

    {{--<li class="nav-item">--}}
        {{--<a class="nav-link" href="#">Participate Of Topic</a>--}}
    {{--</li>--}}
</ul>
