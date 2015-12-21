@extends('layouts.default')

@section('content')
<style>
    html, body {
        height: 100%;
    }

    body {
        margin: 0;
        padding: 0;
        width: 100%;
        font-family: 'Lato';
    }

    .header {
        margin-top: 40px;
    }
    .header .title {
        font-size: 66px;
    }
</style>

<div class="container">
    <div class="pull-right" style="margin-top:10px;">
        <a href="{{ route('admin.auth.login')}}">Login</a>
    </div>

    <div class="header text-center">
        <div class="title">Hey Community</div>
        <div>
            DEMO: <a href="demo.hey-community.online" target="_blank">demo.hey-community.online</a> <br>
            GitHub: <a href="https://github.com/dev4living/hey-community" target="_blank">https://github.com/dev4living/hey-community</a>
        </div>
    </div>

    <!-- -->
    <div style="margin-top:30px;" class="row">
        <div class="col-sm-8 col-sm-offset-2">
            <div class="text-center">New Tenant</div>
            <hr>
        </div>

        <div class="col-sm-offset-3 col-sm-6">
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {!! Form::open(array('route' => 'home.store-tenant', 'method' => 'post', 'class' => 'form form-horizontal')) !!}
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="title">Site Name</label>
                    <div class="col-sm-9">
                        <input class="form-control" type="text" name="site_name" value="{{ old('site_name') }}" placeholder="">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label" for="title">Site Domain</label>
                    <div class="col-sm-9">
                        <input class="form-control" type="text" name="domain" value="{{ old('domain') }}" placeholder="">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label" for="title">Tenant Email</label>
                    <div class="col-sm-9">
                        <input class="form-control" type="text" name="email" value="{{ old('email') }}" placeholder="">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label" for="title">Tenant Phone</label>
                    <div class="col-sm-9">
                        <input class="form-control" type="text" name="phone" value="{{ old('phone') }}" placeholder="">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label" for="title">Password</label>
                    <div class="col-sm-9">
                        <input class="form-control" type="password" name="password" value="{{ old('password') }}" placeholder="">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-9 col-sm-offset-3">
                        <button type="submit" class="btn btn-primary btn-block">Submit</button>
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
