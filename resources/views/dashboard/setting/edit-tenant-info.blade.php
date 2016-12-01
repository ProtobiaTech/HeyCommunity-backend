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

                {!! Form::open(array('url' => '/dashboard/setting/update-tenant-info', 'method' => 'post', 'class' => 'form form-horizontal')) !!}
                    <div class="form-group {{ $errors->has('site_name') ? 'has-error' : '' }}">
                        <label for="input-site-name" class="col-sm-2 control-label">{{ trans('dashboard.Community Name') }}</label>
                        <div class="col-sm-10">
                            <input type="string" name="site_name" class="form-control" id="input-site-name" placeholder="" value="{{ old('site_name', $tenant->site_name) }}">
                            @if ($errors->has('site_name'))
                            <div class="help-block">{{ $errors->first('site_name') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="input-site-name" class="col-sm-2 control-label">{{ trans('dashboard.Domain') }}</label>
                        <div class="col-sm-10">
                            <input disabled type="string" name="domain" class="form-control" id="input-site-name" placeholder="" value="{{ old('domain', $tenant->domain) }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="input-site-name" class="col-sm-2 control-label">{{ trans('dashboard.Sub Domain') }}</label>
                        <div class="col-sm-10">
                            <input disabled type="string" name="sub_domain" class="form-control" id="input-site-name" placeholder="" value="{{ old('sub_domain', $tenant->sub_domain) }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="input-site-name" class="col-sm-2 control-label">{{ trans('dashboard.Email') }}</label>
                        <div class="col-sm-10">
                            <input disabled type="string" name="email" class="form-control" id="input-site-name" placeholder="" value="{{ old('email', $tenant->email) }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="input-site-name" class="col-sm-2 control-label">{{ trans('dashboard.Phone') }}</label>
                        <div class="col-sm-10">
                            <input disabled type="string" name="phone" class="form-control" id="input-site-name" placeholder="" value="{{ old('phone', $tenant->phone) }}">
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

