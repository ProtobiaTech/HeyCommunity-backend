@extends('layouts.admin')

@section('content')
<div id="getting-started">
  <br>
  <br>
  <br>
  <div class="text-center">
    <h2>Login With Admin</h2>
    <br>
  </div>

  <div class="container">
    <div class="row">
      <div class="col-sm-6 col-sm-offset-3">
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>{{ trans('dashboard.Login failed') }}</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <br>
        {!! Form::open(array('url' => url('admin/log-in'), 'method' => 'post', 'class' => 'form form-horizontal')) !!}
          <div class="form-group">
              <label class="col-sm-3 control-label" for="title">{{ trans('dashboard.Email') }}</label>
              <div class="col-sm-9">
                  <input class="form-control" type="text" name="email" value="{{ old('email') }}" placeholder="hello@hey-community.com">
              </div>
          </div>

          <div class="form-group">
              <label class="col-sm-3 control-label" for="title">{{ trans('dashboard.Password') }}</label>
              <div class="col-sm-9">
                  <input class="form-control" type="password" name="password" value="" placeholder="Password">
              </div>
          </div>


          <div class="form-group">
              <div class="col-sm-9 col-sm-offset-3">
                  <button type="submit" class="btn btn-primary btn-block">提交</button>
              </div>
          </div>
        {!! Form::close() !!}
      </div>
    </div>
  </div>
</div>

@endsection
