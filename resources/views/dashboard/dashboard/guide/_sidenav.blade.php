<ul id="section-sidenav" class="nav nav-pills nav-stacked" role="tablist">
    <li class="{{ Request::is('*/getting-started') ? 'active' : '' }}"><a href="{{ ('./getting-started') }}">{{ trans('dashboard.Getting started') }}</a></li>
    <li class="disabled {{ Request::is('*/null') ? 'active' : '' }}"><a d-href="{{ ('./user') }}">{{ trans('dashboard.WeChat WebApp') }}</a></li>
    <li class="disabled {{ Request::is('*/null') ? 'active' : '' }}"><a d-href="{{ ('./user') }}">{{ trans('dashboard.Hybrid App') }}</a></li>
</ul>
