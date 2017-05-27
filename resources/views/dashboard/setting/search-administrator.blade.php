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
            </div>

            <div id="section-mainbody">
                <p class="h3 text-center">{{ trans('dashboard.Add Administrator') }}</p>

                <br>
                <br>
                {!! Form::open(array('url' => '/dashboard/setting/search-administrator', 'method' => 'post', 'class' => 'form form-horizontal')) !!}
                    <div class="form-group {{ $errors->has('search_key') ? 'has-error' : '' }}">
                        <label for="input-id-or-phone" class="col-sm-2 control-label">{{ trans('dashboard.ID Phone Or Nickname') }}</label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <input type="string" name="search_key" class="form-control" id="input-id-or-phone" placeholder="" value="{{ old('search_key') }}">
                                 <span class="input-group-btn">
                                    <button type="submit" class="btn btn-default" type="button">{{ trans('dashboard.Search') }}</button>
                                </span>
                            </div>
                            @if ($errors->has('search_key'))
                                <div class="help-block">{{ $errors->first('search_key') }}</div>
                            @endif
                        </div>
                    </div>
                {!! Form::close() !!}

                @if (isset($users) && $users->count())
                    <br>
                    <br>
                    <table class="table table-striped">
                        <tr>
                            <th>ID</th>
                            <th>{{ trans('dashboard.Avatar') }}</th>
                            <th>{{ trans('dashboard.Nickname') }}</th>
                            <th>{{ trans('dashboard.Phone') }}</th>
                            <th>{{ trans('dashboard.Operations') }}</th>
                        </tr>
                        @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>
                                <img style="height:20px" src="{{ $user->avatar }}">
                            </td>
                            <td>{{ $user->nickname }}</td>
                            <td>{{ $user->phone }}</td>
                            <td>
                                @if ($user->is_admin)
                                    <a disabled class="btn btn-primary btn-xs">{{ trans('dashboard.Is Administrator') }}</a>
                                @else
                                    <a href="javascript:if (confirm('{{ trans('dashboard.Are you sure?') }}')) { $('#form-user-{{ $user->id }}').submit(); }" class="btn btn-primary btn-xs">{{ trans('dashboard.Add') }}</a>
                                    {!! Form::open(['url' => url('/dashboard/setting/add-administrator'), 'id' => ('form-user-' . $user->id), 'class' => 'hidden', 'method' => 'post']) !!}
                                        <input type="hidden" name="id" value="{{ $user->id }}">
                                        {!! Form::submit('Submit', ['class' => 'btn btn-xs']) !!}
                                    {!! Form::close() !!}
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </table>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

