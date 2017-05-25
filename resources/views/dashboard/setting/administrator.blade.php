@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-2">
            @include('dashboard.setting._sidenav')
        </div>

        <div class="col-sm-9">
            <div id="section-breadcrumb">
                <ol class="breadcrumb">
                    <li><a href="{{ url('/dashboard') }}">HeyCommunity</a></li>
                    <li><a href="{{ url('/dashboard/setting') }}">{{ trans('dashboard.Setting') }}</a></li>
                    <li class="active">{{ trans('dashboard.Administrator') }}</li>
                </ol>

                <div class="pull-right">
                    <a href="{{ url('/dashboard/setting/search-administrator') }}" class="btn btn-default btn-sm">{{ trans('dashboard.Add') }}</a>
                </div>
            </div>

            <div id="section-mainbody">
                <p class="h3 text-center">{{ trans('dashboard.Administrator List') }}</p>

                <table class="table table-striped">
                    <tr>
                        <th>ID</th>
                        <th>{{ trans('dashboard.Avatar') }}</th>
                        <th>{{ trans('dashboard.Nickname') }}</th>
                        <th>{{ trans('dashboard.Phone') }}</th>
                        <th>{{ trans('dashboard.Operations') }}</th>
                    </tr>
                    @foreach ($administrators as $administrator)
                    <tr>
                        <td>{{ $administrator->id }}</td>
                        <td>
                            <img style="height:20px" src="{{ $administrator->avatar }}">
                        </td>
                        <td>{{ $administrator->nickname }}</td>
                        <td>{{ $administrator->phone }}</td>
                        <td>
                            <a href="javascript:if (confirm('{{ trans('dashboard.Are you sure?') }}')) { $('#form-user-{{ $administrator->id }}').submit(); }" class="btn btn-danger btn-xs">{{ trans('dashboard.Delete') }}</a>
                            {!! Form::open(['url' => url('/dashboard/setting/destroy-administrator'), 'id' => ('form-user-' . $administrator->id), 'class' => 'hidden', 'method' => 'post']) !!}
                                <input type="hidden" name="id" value="{{ $administrator->id }}">
                                {!! Form::submit('Submit', ['class' => 'btn btn-xs']) !!}
                            {!! Form::close() !!}
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

