<ul id="section-sidenav" class="nav nav-pills nav-stacked" role="tablist">
    <li class="{{ Request::is('*/timeline') ? 'active' : '' }}"><a href="{{ ('./timeline') }}">{{ trans('dashboard.Timeline') }}</a></li>
    <li class="{{ Request::is('*/user') ? 'active' : '' }}"><a href="{{ ('./user') }}">{{ trans('dashboard.User') }}</a></li>
</ul>
