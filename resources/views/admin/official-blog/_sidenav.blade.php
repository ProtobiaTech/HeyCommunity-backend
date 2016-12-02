<ul id="section-sidenav" class="nav nav-pills nav-stacked hidden-xs" role="tablist">
    <li class="{{ Request::is('*/blog') ? 'active' : '' }}"><a href="{{ url('admin/blog') }}">{{ trans('dashboard.List') }}</a></li>
    <li class="{{ Request::is('*/create') ? 'active' : '' }}"><a href="{{ url('admin/blog/create') }}">{{ trans('dashboard.Create') }}</a></li>
</ul>

<ul id="section-sidenav" class="nav nav-pills visible-xs-block" role="tablist">
    <li class="{{ Request::is('*/blog') ? 'active' : '' }}"><a href="{{ url('admin/blog') }}">{{ trans('dashboard.List') }}</a></li>
    <li class="{{ Request::is('*/create') ? 'active' : '' }}"><a href="{{ url('admin/blog/create') }}">{{ trans('dashboard.Create') }}</a></li>
</ul>

<br>
