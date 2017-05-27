<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link {{ Request::is('*notice') ? 'active' : '' }}" href="{{ url('ucenter/notice') }}">Notices</a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ Request::is('*timeline') ? 'active' : '' }}" href="{{ url('ucenter/timeline') }}">Timeline</a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ Request::is('*topic') ? 'active' : '' }}" href="{{ url('ucenter/topic') }}">Topic</a>
    </li>
</ul>
