@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="text-center">
        <h2>Hey Community Cloud Platform</h2>
        <br>
    </div>

    <!-- Login panel -->
    <div class="row">
        <div class="col-sm-6 col-sm-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    注册一个新社区
                </div>
                <div class="panel-body">
                    {!! Form::open(array('url' => '/sign-up', 'method' => 'post', 'class' => 'form form-horizontal')) !!}
                        <div class="form-group {{ $errors->has('site_name') ? 'has-error' : '' }}">
                            <label class="col-sm-3 control-label" for="title">应用名称</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" name="site_name" value="{{ old('site_name') }}" placeholder="应用名称">
                                @if ($errors->has('site_name'))
                                <div class="help-block">{{ $errors->first('site_name') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('domain') ? 'has-error' : '' }}">
                            <label class="col-sm-3 control-label" for="title">域名</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <span class="input-group-addon" id="sizing-addon1">http://</span>
                                    <input class="form-control" type="text" name="domain" value="{{ old('domain') }}" placeholder="site-domain.com">
                                </div>
                                @if ($errors->has('domain'))
                                <div class="help-block">{{ $errors->first('domain') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('sub_domain') ? 'has-error' : '' }}">
                            <label class="col-sm-3 control-label" for="title">子域名</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <span class="input-group-addon" id="sizing-addon1">http://</span>
                                    <input class="form-control" type="text" name="sub_domain" value="{{ old('sub_domain') }}" placeholder="sub-domain">
                                    <span class="input-group-addon" id="sizing-addon1">.hey-community.com</span>
                                </div>
                                @if ($errors->has('sub_domain'))
                                <div class="help-block">{{ $errors->first('sub_domain') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                            <label class="col-sm-3 control-label" for="title">管理员邮箱</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" name="email" value="{{ old('email') }}" placeholder="admin@hey-community.com">
                                @if ($errors->has('email'))
                                <div class="help-block">{{ $errors->first('email') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
                            <label class="col-sm-3 control-label" for="title">管理员手机</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" name="phone" value="{{ old('phone') }}" placeholder="13112341234">
                                @if ($errors->has('phone'))
                                <div class="help-block">{{ $errors->first('phone') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                            <label class="col-sm-3 control-label" for="title">管理员密码</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="password" name="password" value="{{ old('password') }}" placeholder="管理员密码">
                                @if ($errors->has('password'))
                                <div class="help-block">{{ $errors->first('password') }}</div>
                                @endif
                            </div>
                        </div>



                        <div class="form-group">
                            <div class="col-sm-9 col-sm-offset-3">
                                <button type="submit" class="btn btn-primary btn-block">注册</button>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
