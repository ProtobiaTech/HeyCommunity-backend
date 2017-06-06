<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $system = \App\System::find(1); ?>
    <meta name="description" content="{{ $system->community_description }}">
    <meta name="keywords" content="{{ $system->community_keywords }}">
    <meta name="author" content="">

    <title>{{ $system->community_name }}</title>

    {!! $system->community_statistical_code !!}

    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600' rel='stylesheet' type='text/css'>
    <link href="{{ asset('bootstrap-assets/css/toolkit.css') }}" rel="stylesheet">

    <link href="{{ asset('bootstrap-assets/css/application.css') }}" rel="stylesheet">
    <link href="{{ asset('bootstrap-assets/css/website.css') }}" rel="stylesheet">
    <link href="{{ asset('bower-assets/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">

    <style>
        /* note: this is a hack for ios iframe for bootstrap themes shopify page */
        /* this chunk of css is not part of the toolkit :) */
        body {
            width: 1px;
            min-width: 100%;
            *width: 100%;
        }
    </style>
</head>

<body class="with-top-navbar">
<div class="growl" id="app-growl"></div>

<nav class="navbar navbar-toggleable-sm fixed-top navbar-inverse bg-primary app-navbar">
    <button
            class="navbar-toggler navbar-toggler-right hidden-md-up"
            type="button"
            data-toggle="collapse"
            data-target="#navbarResponsive"
            aria-controls="navbarResponsive"
            aria-expanded="false"
            aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <a class="navbar-brand" href="{{ url('/') }}">
        HeyCommunity &nbsp;&nbsp;
    </a>

    <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav mr-auto">
        <!--
          <li class="nav-item {{ Request::is('/') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('/') }}">@lang('hc.home')</a>
          </li>
          -->

            <li class="nav-item {{ Request::is('timeline*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('/timeline') }}">@lang('hc.timeline')</a>
            </li>
            <li class="nav-item {{ Request::is('topic*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('/topic') }}">@lang('hc.topic')</a>
            </li>
        <!--
          <li class="nav-item {{ Request::is('activity*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('/activity') }}">@lang('hc.activity')</a>
          </li>
          -->

            @if (Auth::user()->check())
                <li class="nav-item hidden-md-up">
                    <a class="nav-link" href="">Notifications</a>
                </li>
                <li class="nav-item hidden-md-up">
                    <a class="nav-link" href="{{ url('/auth/logout') }}">@lang('hc.logout')</a>
                </li>
            @endif
        </ul>

        <form class="form-inline float-right hidden-sm-down">
            <input disabled class="form-control" type="text" data-action="grow" placeholder="@lang('hc.search')">
        </form>

        <ul id="#js-popoverContent" class="nav navbar-nav float-right mr-0 hidden-sm-down">
            <li class="nav-item">
                <a class="app-notifications nav-link" href="{{ url('/ucenter') }}">
                    <span class="icon icon-bell"></span>
                </a>
            </li>
            <li class="nav-item ml-2">
                <button class="btn btn-default navbar-btn navbar-btn-avatar" data-toggle="popover">
                    @if (Auth::user()->check())
                        <img class="rounded-circle" style="background-color:#eee;"
                             src="{{ Auth::user()->user()->avatar }}">
                    @else
                        <img class="rounded-circle" style="background-color:#eee;"
                             src="{{ url('/assets/images/userAvatar-default.png') }}">
                    @endif
                </button>
            </li>
        </ul>

        <ul class="nav navbar-nav hidden-xs-up" id="js-popoverContent">
            @if (Auth::user()->check())
                <li class="nav-item"><a class="nav-link" href="{{ url('auth/logout') }}">@lang('hc.logout')</a></li>
            @else
                <li class="nav-item"><a class="nav-link" href="{{ url('auth/login') }}">@lang('hc.login')</a></li>
            @endif
        </ul>
    </div>
</nav>

@yield('content')


<footer class="container">
    <br>
    <div class="card card-link-list">
        <div class="card-block">
            <div class="text-center">
                ©2015 - 2017 HeyCommunity
            </div>
            <div class="text-center">
                <a href="#">@lang('hc.about')</a>
                <a href="#">@lang('hc.help')</a>
                <a href="#">@lang('hc.terms')</a>
                <a href="#">@lang('hc.privacy')</a>
                <a href="#">@lang('hc.cookies')</a>
                <a href="#">@lang('hc.ads') </a>
                <a href="#">@lang('hc.info')</a>
                <a href="#">@lang('hc.brand')</a>
                <a href="#">@lang('hc.blog')</a>
                <a href="#">@lang('hc.status')</a>
                <a href="#">@lang('hc.apps')</a>
                <a href="#">@lang('hc.jobs')</a>
                <a href="#">@lang('hc.advertise')</a>
            </div>
        </div>
    </div>
</footer>

<script src="{{ asset('bootstrap-assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('bootstrap-assets/js/tether.min.js') }}"></script>
<script src="{{ asset('bootstrap-assets/js/chart.js') }}"></script>
<script src="{{ asset('bootstrap-assets/js/toolkit.js') }}"></script>
<script src="{{ asset('bootstrap-assets/js/application.js') }}"></script>
<script>
    // execute/clear BS loaders for docs
    $(function () {
        if (window.BS && window.BS.loader && window.BS.loader.length) {
            while (BS.loader.length) {
                (BS.loader.pop())()
            }
        }
    })
</script>

@yield('script')
</body>
</html>
