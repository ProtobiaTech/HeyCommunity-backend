<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <link rel="stylesheet" type="text/css" href="assets/style/home.css">
    <link rel="stylesheet" type="text/css" href="bower-assets/bootstrap/dist/css/bootstrap.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <style>
    .nav {
        background-color: #428bca;
        padding: 0 30px;
    }
    .nav a {
        color: #fff;
        padding: 10px 5px;
    }
    </style>
</head>

<body>
    @include('layouts.common')
    <nav class="nav">
        <a class="h1" href="{{ url('/') }}" style="color:#fff; font-size:18px; line-height:20px; padding-right:20px; display:inline;">HeyCommunity</a>
        <a class="blog-nav-item" href="{{ url('about-us') }}">About Us</a>
        <a class="blog-nav-item" href="{{ url('open-resource') }}">Open Resource</a>
    </nav>
    <div class="container">
        <h2>About Us</h2>

        Community Network Solutions

        <div style="margin-top:20px;">
            &copy;2016 Dev4living
        </div>
    </div>
</body>
</html>
