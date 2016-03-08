<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <link rel="stylesheet" type="text/css" href="assets/style/home.css">
    <link rel="stylesheet" type="text/css" href="bower-assets/bootstrap/dist/css/bootstrap.min.css">
</head>

<body>
    <div id="main-body">
        <div class="container-fluid">
            <div class="row" style="margin:0 30px 15px;">
                <div class="col-sm-6">
                    <div class="phone-box">
                        <iframe src="http://demo.hey-community.cn"></iframe>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="panel panel-default panel-new-tenant">
                        <div class="panel-body">
                            <p class="text-center caption">New Community</p>

                            @if (count($errors) > 0)
                            <div class="alert alert-danger" style="margin:0 15px;">
                                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif

                            {!! Form::open(array('route' => 'home.store-tenant', 'method' => 'post', 'class' => 'form')) !!}
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <input class="form-control" type="text" name="site_name" value="{{ old('site_name') }}" placeholder="Site Name">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <div class="input-group">
                                            <span class="input-group-addon" id="sizing-addon1">http://</span>
                                            <input class="form-control" type="text" name="domain" value="{{ old('domain') }}" placeholder="site-domain.com">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <div class="input-group">
                                            <span class="input-group-addon" id="sizing-addon1">http://</span>
                                            <input class="form-control" type="text" name="sub_domain" value="{{ old('sub_domain') }}" placeholder="sub-domain">
                                            <span class="input-group-addon" id="sizing-addon1">.hey-community.cn</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <input class="form-control" type="text" name="email" value="{{ old('email') }}" placeholder="Admin Email">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <input class="form-control" type="text" name="phone" value="{{ old('phone') }}" placeholder="Admin Phone">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <input class="form-control" type="password" name="password" value="{{ old('password') }}" placeholder="Password">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-12" style="margin-top:2px;">
                                        <button type="submit" class="btn btn-primary btn-block">Submit</button>
                                    </div>
                                </div>
                            {!! Form::close() !!}

                        </div>

                        <div style="margin:-15px 30px 20px;">
                            <hr style="margin:15px 0;">
                            <div>
                                You have a community? <a href="{{ route('admin.auth.login')}}">Sign-in</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <div class="pull-right">
                        &copy; 2016 Dev4living
                    </div>
                    <nav>
                        <a href="">ABOUT US</a>
                        <a href="">SUPPORT</a>
                        <a href="">BLOG</a>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
