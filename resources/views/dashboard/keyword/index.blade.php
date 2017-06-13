@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-2">
                @include('dashboard.keyword._sidenav')
            </div>

            <div class="col-sm-10">
                <div id="section-breadcrumb">
                    <ol class="breadcrumb">
                        <li><a href="{{ url('/dashboard') }}">HeyCommunity</a></li>
                        <li><a href="{{ url('/dashboard/keyword') }}">{{ trans('dashboard.Keyword') }}</a></li>
                        <li class="active">{{ trans('dashboard.List') }}</li>
                    </ol>
                </div>

                <div id="section-mainbody">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>{{ trans('dashboard.Keyword name') }}</th>
                            <th>{{ trans('dashboard.Keyword timeline') }}</th>
                            <th>{{ trans('dashboard.Keyword topic') }}</th>
                            <th>{{ trans('dashboard.Created At') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($keywords as $keyword)
                            <tr>
                                <td>{{ $keyword->id }}</td>
                                <td>{{ $keyword->name }}</td>
                                <td>{{ $keyword->timeline_count }}</td>
                                <td>{{ $keyword->topic_count }}</td>
                                <td>{{ $keyword->created_at }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <div>
                        {!! $keywords->render() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

