@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="text-center">
        <h2>Hey Community</h2>
        <br>
    </div>

    <!-- Login panel -->
    <div class="row">
        <div class="col-sm-6 col-sm-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Login
                </div>
                <div class="panel-body">
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

                    {!! Form::open(array('url' => '/log-in', 'method' => 'post', 'class' => 'form form-horizontal')) !!}
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="title">Email</label>
                            <div class="col-sm-8">
                                <input class="form-control" type="text" name="email" value="{{ old('email') }}" placeholder="place enter email">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="title">Password</label>
                            <div class="col-sm-8">
                                <input class="form-control" type="password" name="password" value="" placeholder="place enter password">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-8 col-sm-offset-3">
                                <button type="submit" class="btn btn-block btn-primary">Login</button>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
