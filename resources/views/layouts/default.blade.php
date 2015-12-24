<html lang="zh">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="author" contents="dev4living.com">
    <meta name="keywords" contents="">
    <meta name="description" contents="">
    <title>Hey Community</title>

    <link href="{{ asset('/bower-assets/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/bower-assets/bootswatch/flatly/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/bower-assets/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <script src="{{ asset('bower-assets/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('bower-assets/bootstrap/dist/js/bootstrap.min.js') }}"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    @include('layouts.common')
</head>

<body>

    @yield('content')

    <footer class="container text-center" style="margin-top:60px; padding-bottom:30px;">
        <hr>
        &copy;2015 <a href="http://www.dev4living.com" target="_blank">dev4living.com</a>
    </footer>
</body>
</html>

