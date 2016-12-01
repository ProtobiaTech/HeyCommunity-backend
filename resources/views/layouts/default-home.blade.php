<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HeyCommunity | 免费开源的线上社区解决方案,致力社群多样精彩社交</title>
  <meta name="keywords" content="HeyCommunity, hey-community, SNS, 社区, 嘿社区, HEY社区, 社交网络, 开源社区, 开源社交, 社群">
  <meta name="description" content="HeyCommunity 是为中小社群量身打造的线上社区解决方案，其构建的 app 可适用于 iOS / android / windowPhone / Browser 等终端。让人欣喜的是其 app 是开源的 GPLv3 授权，我们为有需要的用户提供定制开发和运营服务">

  <title>HeyCommunity</title>
  <link href="ionic-assets/css/site8e29.css?25" rel="stylesheet">
  <link rel="stylesheet" href="ionic-assets/css/ionicons.min.css">
  <link rel="stylesheet" type="text/css" href="ionic-assets/css/slick.css"/>
  <link rel="stylesheet" type="text/css" href="ionic-assets/css/slick-theme.css"/>

  <script src="{{ url('bower-assets/jquery/dist/jquery.min.js') }}"></script>
  <script>
    $(function() {
      setTimeout(function(){
        $('.snap-bar').addClass('active');
      },1500);
    });
  </script>

  <!-- -->
  <script type="text/javascript" src="ionic-assets/js/slick.js"></script>
  <script>
  $(document).ready(function() {
    $('#slider').slick({
      dots: true,
      infinite: true,
      speed: 300,
      slidesToShow: 1,
      adaptiveHeight: false,
      fade: true,
      cssEase: 'ease-in-out',
      draggable: false,
      autoplay: true,
      autoplaySpeed: 8000,
      focusOnSelect: false,
      // https://github.com/kenwheeler/slick/issues/1537
      accessibility: false
    }).on('beforeChange', function(event, slick, currentSlide, nextSlide){
      $slide = $("#slider .slick-current");
      $slide.addClass('slick-fade-out');
      setTimeout(function(){
        $slide.removeClass('slick-fade-out')
      }, 300) // match speed in slick config object above
    });
  });
  </script>
  <style>
    @media (min-width: 768px) {
      .nav .active {
        border-top: 3px solid #B5CAFF !important;
        opacity: 1 !important;
      }
    }

    @media (max-width: 767px) {
      .nav .nav-link.active {
        color: #4F8EF7 !important;
      }

      .nav .nav-link:hover {
        color: #4F8EF7 !important;
      }

      .nav .dropdown-menu li a {
        color: #fff !important;
      }

      .nav .dropdown-menu li a:hover {
        color: #4F8EF7 !important;
      }
    }

    @media (max-width: 991px) {
      .slogan {
        display: none;
      }
    }
  </style>
</head>

<body class="full-page {{ Request::is('/') ? 'home' : '' }}">
<div id="creator-bar" class="snap-bar active hide">
  <span class="large">HeyCommunity v2.0.0-beta.1 is comming</span>
</div>



<nav class="navbar navbar-default horizontal-gradient" role="navigation">
  <div class="container">
    <div class="navbar-header">
      <a style="font-family: AvenirNextLTPro-Regular, 'Helvetica Neue', Helvetica, Arial, sans-serif; padding-top:20px; font-size:32px; color:#fff; opacity:1; line-height:1em;" class="navbar-brand" href="/">
        HeyCommunity
        <small class="slogan" style="color:#eee; font-size:16px;">线上社区解决方案</small>
      </a>
      <button type="button" class="navbar-toggle button ionic" data-toggle="collapse" data-target=".navbar-ex1-collapse">
        <i class="icon ion-navicon"></i>
      </button>
    </div>

    <div class="collapse navbar-collapse navbar-ex1-collapse" style="height: auto;">
      <ul class="nav navbar-nav navbar-right">
        <li><a class="nav-link {{ Request::is('/') ? 'active' : '' }}" href="{{ url('/') }}">功能特性</a></li>
        <li><a class="nav-link {{ Request::is('cloud') ? 'active' : '' }}" href="{{ url('/cloud') }}">云社区</a></li>
        <li class="hide"><a class="nav-link {{ Request::is('business') ? 'active' : '' }}" href="{{ url('business') }}">商业解决方案</a></li>
        <li><a class="nav-link {{ Request::is('open-sources') ? 'active' : '' }}" href="{{ url('open-sources') }}">开源软件</a></li>
        <li><a class="nav-link {{ Request::is('about-us') ? 'active' : '' }}" href="{{ url('about-us') }}">关于我们</a></li>

        @if (Auth::tenant()->check())
          <li class="dropdown">
            <a href="#" class="dropdown-toggle nav-link " data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::tenant()->user()->site_name }} <span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
              <div class="arrow-up"></div>
              <li><a class="nav-link" href="{{ url('dashboard') }}">管理后台</a></li>
              <li><a class="nav-link" href="{{ url('logout') }}">退出</a></li>
            </ul>
          </li>
        @else
          <li class="dropdown">
            <a href="#" class="dropdown-toggle nav-link " data-toggle="dropdown" role="button" aria-expanded="false">注册/登录 <span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
              <div class="arrow-up"></div>
              <li><a class="nav-link" href="{{ url('login') }}">登录</a></li>
              <li><a class="nav-link" href="{{ url('cloud') }}">注册云社区</a></li>
            </ul>
          </li>
        @endif
      </ul>
    </div>
  </div>
</nav>


<!-- content -->
@yield('content')


<!-- footer -->
<footer class="footer">
  <!-- -->
  <nav class="base-links">
    <dl style="padding-left:0 !important;">
      <dt>产品</dt>
      <dd><a href="{{ url('cloud') }}">云社区</a></dd>
      <dd class="hide"><a href="{{ url('business') }}">商业解决方案</a></dd>
      <dd><a href="{{ url('open-sources') }}">开源软件</a></dd>
    </dl>

    <dl style="padding-left:0 !important;">
      <dt>协议</dt>
      <dd><a disabled>用户协议</a></dd>
      <dd><a disabled>隐私承诺</a></dd>
    </dl>

    <dl style="padding-left:0 !important;">
      <dt>我们</dt>
      <dd><a href="{{ url('about-us') }}">关于我们</a></dd>
      <dd><a href="{{ url('jobs') }}">工作机会</a></dd>
    </dl>

    <dl style="padding-left:0 !important;">
      <dt>开放源代码</dt>
      <dd><a href="https://github.com/dev4living/HeyCommunity" target="_blank">HeyCommunity@Github</a></dd>
      <dd><a href="https://www.gnu.org/licenses/gpl-3.0.html" target="_blank">GPLv3 License</a></dd>
    </dl>
  </nav>


  <!-- -->
  <div class="newsletter row">
    <div class="newsletter-container">
      <div class="col-sm-7">
        <div class="newsletter-text">与我们保持联系</div>
        <div class="sign-up">通过电子邮箱，可以在第一时间获取 产品更新 / 产品研发计划 / 公司动态 等信息</div>
      </div>

      <form action="http://codiqa.createsend.com/t/t/s/jytylh/" method="post" class="input-group col-sm-5">
        <input disabled id="fieldEmail" name="cm-jytylh-jytylh" class="form-control" type="email" placeholder="Email" required />
        <span class="input-group-btn">
          <button disabled class="btn btn-default" type="submit">订阅</button>
        </span>
      </form>
    </div>
  </div>


  <!-- -->
  <div class="copy">
    <div class="copy-container">
      <p class="authors hidden-xs">
        Thinks to the
        <a href="http://ionicframework.com" target="_blank">Ionic Framework</a>
        and
        <a href="http://angular.io" target="_blank">Angular</a>
        <span>|</span>
        &copy;2016 <a target="_blank" href="http://www.protobia.tech">Protobia.tech</a>
      </p>
      <p class="authors hidden-sm hidden-md hidden-lg" style="text-align:center;">
        Thinks to the
        <a href="http://ionicframework.com" target="_blank">Ionic Framework</a>
        and
        <a href="http://angular.io" target="_blank">Angular</a>
        <br>
        &copy;2016 <a target="_blank" href="http://www.protobia.tech">Protobia.tech</a>
      </p>
    </div>
  </div>
</footer>

<script src="ionic-assets/js/bootstrap.min.js"></script>
<script src="ionic-assets/js/sitec4ca.js?1"></script>

<!-- DaoVoice -->
<script>(function(i,s,o,g,r,a,m){i["DaoVoiceObject"]=r;i[r]=i[r]||function(){(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;a.charset="utf-8";m.parentNode.insertBefore(a,m)})(window,document,"script",('https:' == document.location.protocol ? 'https:' : 'http:') + "//widget.daovoice.io/widget/86480a80.js","daovoice");</script>
@if (Auth::tenant()->guest())
  <script>
    daovoice('init', {
      app_id: "86480a80",
    });
    daovoice('update');
  </script>
@else
  <script>
    daovoice('init', {
      app_id: "86480a80",
      email: "{{ Auth::tenant()->user()->email }}",             // 替换成当前用户的邮件
      user_id: "{{ Auth::tenant()->user()->id }}",              // 选填: 替换成当前用户的唯一标识
      signed_up: {{ Auth::tenant()->user()->created_at->getTimestamp() }},  // 选填: // 替换当前用户的注册时间，格式为 Unix 时间戳
      name: "{{ Auth::tenant()->user()->site_name }}",          // 选填: 替换当前用户的真名或者昵称
    });
    daovoice('update');
  </script>
@endif

@include('layouts.common')
</body>
</html>
