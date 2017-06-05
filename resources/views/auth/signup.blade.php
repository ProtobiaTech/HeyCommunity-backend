@extends('layouts.home')

@section('content')
    <div class="container-fluid container-fill-height">
        <div class="container-content-middle">
            {!! Form::open(array('url' => url('auth/sign-up'), 'method' => 'post', 'class' => 'mx-auto app-login-form')) !!}
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

            <div class="alert alert-warning alert-dismissible hidden-xs" role="alert" style="display: none">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <small></small>
            </div>


            <div class="form-group">
                <input class="form-control" type="text" name="nickname" value="{{ old('nickname') }}"
                       placeholder="{{ trans('hc.signup nickname') }}">
            </div>

            <div class="form-group">
                <input class="form-control" type="text" name="phone" value="{{ old('phone') }}"
                       placeholder="{{ trans('hc.signup phone') }}">
            </div>

            <div class="form-group input-group">
                <input class="form-control" type="text" name="code" value="{{ old('code') }}"
                       placeholder="{{ trans('hc.signup code') }}">
                <span class="input-group-btn">
                    <button class="btn btn-primary" type="button" onclick="signUp()"
                            id="captcha">@lang('hc.get code')</button>
                    <button class="btn btn-primary" type="button" id="reset" disabled style="display: none">60</button>
                </span>
            </div>

            <div class="form-group mb-3">
                <input class="form-control" type="password" name="password" value="{{ old('password') }}"
                       placeholder="{{ trans('hc.signup password') }}">
            </div>

            <div class="mb-5 text-center ">
                <button class="btn btn-primary">@lang('hc.signup')</button>
                <a class="btn btn-secondary btn-link" href="{{ url('/auth/login') }}">@lang('hc.cancel')</a>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
@section('script')
    <script>
        function signUp() {
            phone = $("[name='phone']").val();
            $.post('/api/user/get-verification-code', {'phone': phone}, function (result) {
                $(".alert-dismissible").fadeIn().fadeOut(4000);
                $(".alert-dismissible").find('small').text(result[0]);
            });
            reset();
        }

        function reset() {
            $('#captcha').hide();
            var second = 60;
            $('#reset').show();
            var timer = null;

            timer = setInterval(function () {
                second -= 1;
                if (second > 0) {
                    $('#reset').text(second);
                } else {
                    clearInterval(timer);
                    $('#captcha').show();
                    $('#reset').hide();
                }
            }, 1000);
        }
    </script>
@endsection
