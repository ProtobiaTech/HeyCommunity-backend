<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link {{ Request::is('*notice') ? 'active' : '' }}" href="{{ url('ucenter/notice') }}">@lang('hc.notice')</a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ Request::is('*timeline') ? 'active' : '' }}" href="{{ url('ucenter/timeline') }}">@lang('hc.timeline')</a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ Request::is('*topic') ? 'active' : '' }}" href="{{ url('ucenter/topic') }}">@lang('hc.topic')</a>
    </li>
</ul>
