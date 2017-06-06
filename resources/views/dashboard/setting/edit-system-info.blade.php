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
                    <li class="active">{{ trans('dashboard.Edit Community Info') }}</li>
                </ol>
            </div>

            <div id="section-mainbody">
                <p class="h3 text-center">{{ trans('dashboard.Edit Community Info') }}</p>

                {!! Form::open(array('url' => '/dashboard/setting/update-system-info', 'method' => 'post', 'class' => 'form form-horizontal')) !!}
                    <div class="form-group {{ $errors->has('community_name') ? 'has-error' : '' }}">
                        <label for="input-site-name" class="col-sm-2 control-label">{{ trans('dashboard.Community Name') }}</label>
                        <div class="col-sm-10">
                            <input type="string" name="community_name" class="form-control" id="input-site-name" placeholder="" value="{{ old('community_name', $system->community_name) }}">
                            @if ($errors->has('community_name'))
                            <div class="help-block">{{ $errors->first('community_name') }}</div>
                            @endif
                        </div>
                        <label for="input-site-name" class="col-sm-2 control-label">{{ trans('dashboard.Community Keywords') }}</label>
                        <div class="col-sm-10">
                            <input type="string" name="community_keywords" class="form-control" id="input-site-name" placeholder="" value="{{ old('community_keywords', $system->community_keywords) }}">
                            @if ($errors->has('community_keywords'))
                                <div class="help-block">{{ $errors->first('community_keywords') }}</div>
                            @endif
                        </div>
                        <label for="input-site-name" class="col-sm-2 control-label">{{ trans('dashboard.Community Description') }}</label>
                        <div class="col-sm-10">
                            <input type="string" name="community_description" class="form-control" id="input-site-name" placeholder="" value="{{ old('community_description', $system->community_description) }}">
                            @if ($errors->has('community_description'))
                                <div class="help-block">{{ $errors->first('community_description') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-block btn-default">{{ trans('dashboard.Save') }}</button>
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection

