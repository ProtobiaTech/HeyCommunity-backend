@extends('layouts.home')

@section('content')
<div class="container-fluid container-fill-height">
  <div class="container-content-middle">
    {!! Form::open(array('url' => url('auth/login'), 'method' => 'post', 'class' => 'mx-auto app-login-form')) !!}
      <h2 class="text-center ">
        HeyCommunity
        <br>
        <br>
      </h2>

      @if ($errors)
        <ul style="color:red">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
      @endif

      <div class="form-group">
        <input class="form-control" type="text" name="phone" value="{{ old('phone') }}" placeholder="Phone">
      </div>

      <div class="form-group mb-3">
        <input class="form-control" type="password" name="password" value="{{ old('password') }}" placeholder="Password">
      </div>

      <div class="mb-5 text-center ">
        <button class="btn btn-primary">@lang('hc.login')</button>
        <a class="btn btn-secondary btn-link" href="{{ url('/auth/signup') }}">@lang('hc.signup')</a>
      </div>

      <footer class="screen-login text-center">
        <a class="text-muted">Forgot password</a>
      </footer>
    {!! Form::close() !!}
  </div>
</div>
@endsection
