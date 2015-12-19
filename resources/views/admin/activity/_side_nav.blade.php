<ul class="nav nav-pills nav-stacked">
    <li class="{{ Request::is('*activity') ? 'active' : '' }}"><a href="{{ route('admin.activity.index') }}">List</a></li>
    <li class="{{ Request::is('*create') ? 'active' : '' }}"><a href="{{ route('admin.activity.create') }}">Create</a></li>
</ul>
