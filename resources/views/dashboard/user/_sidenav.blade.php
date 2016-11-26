<ul id="section-sidenav" class="nav nav-pills nav-stacked hidden-xs" role="tablist">
    <li class="{{ Request::is('*/user') ? 'active' : '' }}"><a href="{{ ('./user') }}">{{ trans('dashboard.List') }}</a></li>
</ul>

<ul id="section-sidenav" class="nav nav-pills visible-xs-block" role="tablist">
    <li class="{{ Request::is('*/user') ? 'active' : '' }}"><a href="{{ ('./user') }}">{{ trans('dashboard.List') }}</a></li>
</ul>

<br>
