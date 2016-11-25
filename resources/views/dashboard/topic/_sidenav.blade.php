<ul id="section-sidenav" class="nav nav-pills nav-stacked" role="tablist">
    <li class="{{ Request::is('*/index') ? 'active' : '' }}"><a href="{{ url('dashboard/topic/index') }}">{{ trans('dashboard.List') }}</a></li>
    <li class="{{ Request::is('*/nodes') ? 'active' : '' }}"><a href="{{ url('dashboard/topic/nodes') }}">{{ trans('dashboard.Nodes') }}</a></li>
</ul>
