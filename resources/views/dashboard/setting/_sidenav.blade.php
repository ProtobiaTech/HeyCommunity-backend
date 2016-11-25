<ul id="section-sidenav" class="nav nav-pills nav-stacked hidden-xs" role="tablist">
    <li class="{{ Request::is('*/setting/*system-info*') ? 'active' : '' }}"><a href="{{ url('/dashboard/setting/system-info') }}">{{ trans('dashboard.Community Info') }}</a></li>
    <li class="{{ Request::is('*/setting/*wechat-pa*') ? 'active' : '' }}"><a href="{{ url('/dashboard/setting/wechat-pa') }}">{{ trans('dashboard.WeChat PA Info') }}</a></li>
    <li class="{{ Request::is('*/setting/*administrator') ? 'active' : '' }}"><a href="{{ ('./administrator') }}">{{ trans('dashboard.Administrator') }}</a></li>
</ul>

<ul id="section-sidenav" class="nav nav-pills visible-xs-block" role="tablist">
    <li class="{{ Request::is('*/setting/*system-info*') ? 'active' : '' }}"><a href="{{ url('/dashboard/setting/system-info') }}">{{ trans('dashboard.Community Info') }}</a></li>
    <li class="{{ Request::is('*/setting/*wechat-pa*') ? 'active' : '' }}"><a href="{{ url('/dashboard/setting/wechat-pa') }}">{{ trans('dashboard.WeChat PA Info') }}</a></li>
    <li class="{{ Request::is('*/setting/*administrator') ? 'active' : '' }}"><a href="{{ ('./administrator') }}">{{ trans('dashboard.Administrator') }}</a></li>
</ul>

<br>
