<ul id="section-sidenav" class="nav nav-pills hidden-xs" role="tablist">
    <li class="{{ Request::is('*/timeline') ? 'active' : '' }}"><a href="{{ ('./timeline') }}">{{ trans('dashboard.List') }}</a></li>
</ul>

<ul id="section-sidenav" class="nav nav-pills visible-xs-block" role="tablist">
    <li class="{{ Request::is('*/timeline') ? 'active' : '' }}"><a href="{{ ('./timeline') }}">{{ trans('dashboard.List') }}</a></li>
</ul>

<br>
