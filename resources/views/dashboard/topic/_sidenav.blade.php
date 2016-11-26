<ul id="section-sidenav" class="nav nav-pills nav-stacked hidden-xs" role="tablist">
    <li class="{{ Request::is('*/topic') ? 'active' : '' }}"><a href="{{ url('dashboard/topic') }}">{{ trans('dashboard.List') }}</a></li>
    <li class="{{ Request::is('*/nodes') ? 'active' : '' }}"><a href="{{ url('dashboard/topic/nodes') }}">{{ trans('dashboard.Nodes') }}</a></li>
</ul>

<ul id="section-sidenav" class="nav nav-pills visible-xs-block" role="tablist">
    <li class="{{ Request::is('*/topic') ? 'active' : '' }}"><a href="{{ url('dashboard/topic') }}">{{ trans('dashboard.List') }}</a></li>
    <li class="{{ Request::is('*/nodes') ? 'active' : '' }}"><a href="{{ url('dashboard/topic/nodes') }}">{{ trans('dashboard.Nodes') }}</a></li>
</ul>

<br>
