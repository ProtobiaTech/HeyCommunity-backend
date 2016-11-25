<ul id="section-sidenav" class="nav nav-pills nav-stacked" role="tablist">
    <li class="{{ Request::is('*/user') ? 'active' : '' }}"><a href="{{ ('./user') }}">{{ trans('dashboard.List') }}</a></li>
</ul>
