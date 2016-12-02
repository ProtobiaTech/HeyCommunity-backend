@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-2">
            @include('admin.topic._sidenav')
        </div>

        <div class="col-sm-10">
            <div id="section-breadcrumb">
                <ol class="breadcrumb">
                    <li><a href="{{ url('/admin') }}">HeyCommunity</a></li>
                    <li><a href="{{ url('/admin/topic') }}">{{ trans('dashboard.Topic') }}</a></li>
                    <li class="active">{{ trans('dashboard.List') }}</li>
                </ol>
            </div>

            <div id="section-mainbody">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>{{ trans('dashboard.Author') }}</th>
                            <th>{{ trans('dashboard.Title') }}</th>
                            <th>{{ trans('dashboard.Star Num') }}</th>
                            <th>{{ trans('dashboard.Thumb Up Num') }}</th>
                            <th>{{ trans('dashboard.Thumb Down Num') }}</th>
                            <th>{{ trans('dashboard.Comment Num') }}</th>
                            <th>{{ trans('dashboard.Created At') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($topics as $topic)
                        <tr>
                            <td>{{ $topic->id }}</td>
                            <td>{{ $topic->author->nickname }}</td>
                            <td>{{ $topic->title }}</td>
                            <td>{{ $topic->star_num }}</td>
                            <td>{{ $topic->thumb_up_num }}</td>
                            <td>{{ $topic->thumb_down_num }}</td>
                            <td>{{ $topic->comment_num }}</td>
                            <td>{{ $topic->created_at }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div>
                    {!! $topics->render() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

