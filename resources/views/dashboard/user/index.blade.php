@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-2">
            @include('dashboard.user._sidenav')
        </div>

        <div class="col-sm-10">
            <div id="section-breadcrumb">
                <ol class="breadcrumb">
                    <li><a href="{{ url('/dashboard') }}">HeyCommunity</a></li>
                    <li><a href="{{ url('/dashboard/user') }}">{{ trans('dashboard.User') }}</a></li>
                    <li class="active">{{ trans('dashboard.List') }}</li>
                </ol>
            </div>

            <div id="section-mainbody">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>{{ trans('dashboard.Nickname') }}</th>
                            <th>{{ trans('dashboard.Avatar') }}</th>
                            <th>{{ trans('dashboard.Bio') }}</th>
                            <th>{{ trans('dashboard.Gender') }}</th>
                            <th>{{ trans('dashboard.Timeline Num') }}</th>
                            <th>{{ trans('dashboard.Like Num') }}</th>
                            <th>{{ trans('dashboard.Comment Num') }}</th>
                            <th>{{ trans('dashboard.Created At') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->nickname }}</td>
                            <td>
                                <img style="height:20px" src="{{ $user->avatar }}">
                            </td>
                            <td>{{ $user->bio }}</td>
                            <td>{{ \App\User::getGenderName($user->gender) }}</td>
                            <td>{{ $user->timelines->count() }}</td>
                            <td>{{ $user->timelineLikes->count() }}</td>
                            <td>{{ $user->timelineComments->count() }}</td>
                            <td>{{ $user->created_at }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div>
                    {!! $users->render() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

