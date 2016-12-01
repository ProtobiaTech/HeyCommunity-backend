@extends('layouts.default-home')

@section('content')
<div class="container content-container">
  <!-- -->
  <div id="slider" class="primary-row">
    <div class="slide horizontal-gradient">
      <style>
        .slide .btn-row a.btn {
          overflow: hidden;
          text-overflow: ellipsis;
        }

        @media (max-width: 767px) {
          #learn-more {
            margin-bottom: 90px;
          }
          #learn-more .feature-row {
            margin-top: 40px;
            margin-bottom: 60px;
          }
          #learn-more .feature-row h4 {
            padding-left: 140px;
            text-align: center !important;
            margin-top: 30px !important;
            margin-bottom: 15px !important;
          }

          #learn-more .feature-row p {
          }
        }


        @media (max-width: 991px) {
          .features h2 {
            margin-bottom: -20px !important;
          }
        }
      </style>
      <div class="container">
        <div class="row">
          <div class="col-sm-6 fadeIn">
            <h1>
              1分钟开启你的云社区
            </h1>
            <h3>
              再小的社群，都需要有一个独立且功能多样的线上社区，让社群成员之间的交流与互动更加便捷和高效 <br><br>

              运行在微信中，享受微信的授权登录和消息推送带来的便利
            </h3>
            <p class="btn-row">
              <a id="repo-download" class="btn btn-primary btn-download desktop-btn" href="/cloud">开始创建云社区</a>
              <a id="repo-download" class="btn btn-primary btn-download mobile-btn" href="/cloud">开始创建云社区</a>
            </p>
            <p class="version-text">
              v2.0.0-beta.1, 于 2016-11-08 发布
            </p>
          </div>
          <div class="col-sm-6 feature-img one" style="background-image: url(/ionic-assets/img/homepage/focus-1.png)">
            <a href="http://demo.hey-community.com" target="_blank">
              <img style="width:84px; height:84px; border-radius:8px; opacity:0.7;" class="app-icon one" src="assets/images/logo.png">
              <span class="demo-link" style="bottom:45px; font-size:12px;">产品演示</span>
            </a>
          </div>
        </div>
      </div>
    </div>

    <div class="slide horizontal-gradient">
      <div class="container">
        <div class="row">
          <div class="col-sm-6 fadeIn">
            <h1>
              运行在所有平台
            </h1>
            <h3>
              适用于 iOS / Android / Windows Phone 等一切手机操作系统 <br><br>
              更令人惊叹的是，它还能以 WebApp 的形式运行在手机浏览器或 App 内置游览器（如微信）中，输入网址即开即用无须安装
            </h3>
            <p class="btn-row">
              <a class="btn btn-primary btn-download desktop-btn" href="#feature" target="_blank">了解 HeyCommunity 功能特性</a>
              <a class="btn btn-primary btn-download mobile-btn" href="#feature" target="_blank">了解 HeyCommunity 功能特性</a>
            </p>
          </div>
          <div class="col-sm-6 feature-img one" style="background-image: url(/ionic-assets/img/homepage/focus-2.png)">
          </div>
        </div>
      </div>
    </div>

    <div class="slide slide-windows">
      <div class="container">
        <div class="row">
          <div class="col-sm-6 fadeIn">
            <h1>强大</h1>
            <h3>
              先进的混合开发模式，构建在 Angular 和 Ionic 之上 <br>
              易于扩展、快速开发 <br><br>

              丰富的功能组件，满足各种各样的社交方式 <br><br>
              完整的产品生态，从微信 WebApp 到 iOS / Andorid / Windows Phone App 覆盖主流使用场景
            </h3>
            <p class="btn-row">
              <a class="btn btn-primary btn-download desktop-btn" href="#feature" target="_blank">了解 HeyCommunity 功能特性</a>
              <a class="btn btn-primary btn-download mobile-btn" href="#feature" target="_blank">了解 HeyCommunity 功能特性</a>
            </p>
          </div>
          <div class="col-sm-6 feature-img img-loaded"></div>
        </div>
      </div>
    </div>

    <div class="slide slide-market">
      <div class="container">
        <div class="row">
          <div class="col-sm-6 fadeIn">
            <h1>开放</h1>
            <h3>
              HeyCommunity 遵循 GPLv3 开放源代码 <br>
              你可以基于它扩展新功能或调整UI，并且用于商业用途 <br><br>
              一切以用户利益为先，得利于我们开放的胸襟
            </h3>
            <p class="btn-row">
              <a class="btn btn-primary btn-download desktop-btn" href="#feature" target="_blank">了解 HeyCommunity 功能特性</a>
              <a class="btn btn-primary btn-download mobile-btn" href="#feature" target="_blank">了解 HeyCommunity 功能特性</a>
            </p>
          </div>
          <div class="col-sm-6 feature-img img-loaded"></div>
        </div>
      </div>
    </div>
  </div>

  <!-- -->
  <div class="utility-bar">
    <div class="container">
      <div class="row">
        <ul class="social-row ionic col-md-7">
          <li>
            <span class="li-wechat">
              微信公众号
              <div class="hc-qrcode"><img src="assets/images/wechat-qrcode.jpg"></div>
            </span>
            </li>
          <li>用户QQ群: 242078519</li>
        </ul>
        <style>
          .li-wechat {
            cursor: pointer;
          }
          .li-wechat:hover .hc-qrcode {
            display: block;
          }
          .hc-qrcode {
            display: none;
            position: absolute;
            top: 25px;
            z-index: 99;
          }
          .hc-qrcode img {
            width: 140px;
            height: 140px;
          }
        </style>
        <form action="http://codiqa.createsend.com/t/t/s/jytylh/" method="post" disabled class="input-group col-md-5">
          <input disabled name="cm-jytylh-jytylh" class="form-control" type="email" placeholder="通过电子邮箱，订阅我们的动态" required />
          <span class="input-group-btn">
            <button disabled class="btn btn-default" type="submit">订阅</button>
          </span>
        </form>
      </div>
    </div>
  </div>
</div>


<div id="learn-more">
  <div class="desc-row">
    <h3 id="feature">
      HeyCommunity 特性
    </h3>
  </div>

  <div class="feature-row img-performance img-right">
    <h4>微信与云社区，一触即发</h4>
    <p>
      面向初期和小微社群，一分钟即可创建一个云社区
      绑定微信公众号，通过一个网址运行在微信中，可享受到微信授权登录、微信消息推送等功能的便利
    </p>
    <p>
      目前，云社区是免费的
    </p>
  </div>

  <div class="feature-row img-angular">
    <h4>构建在 Angular 和 Ionic 之上，无比强大</h4>
    <p>
      使用先进的混合开发模式，基于 Angular 和 Ionic，我们构建了一个适用于 iOS / Android / Windows Phone 等一切手机操作系统的社交软件
    </p>
    <p>
      更令人惊叹的是，它还能运行手机浏览器中，输入一个网址即开即用，用完即走<br>
    </p>
  </div>

  <div class="feature-row img-learn">
    <h4>广阔的胸襟，用户利益为先</h4>
    <p>
      我们遵循 GPL 许可协议，开放了 HeyCommunity 源代码。你可以自由地使用它，包括用于商业使用。你还可以基于它进行二次开发，进行修改、进行扩展做为自己的产品
    </p>
    <p>
      不及于此，广阔胸襟体现在产品和服务的方方面面，为用户提供尽可能多的帮助
    </p>
  </div>

  <div class="feature-row img-nerds img-right">
    <h4>功能多样 & 优雅体验</h4>
    <p>
      我们解决各式各样的群体线上交流需求，提供丰富的功能帮助他们多元多样的交流与互动。
    </p>
    <p>
      优美的界面，良好的用户体验，使得社区的交流更加美好且舒畅
    </p>
  </div>
</div>


<div class="features">
  <div class="container">
    <h2>多元多样的功能</h2>
    <br>
    <h4 class="" style="margin-bottom:20px;">
    </h4>

    <div class="row">
      <div class="col-md-4">
        <div class="text-center">
          <i style="font-size:90px; line-height:1em;" class="ion-ios-people"></i>
          <h3>用户系统 (User)</h3>
        </div>
        <p class="text-center" style="max-width:100%;">
          在社区里，用户可以使用手机注册或登录 <br>
          同时我们也支持微信登录，在未来我们会支持更多的第三方登录方式 <br>
          <br>
        </p>
      </div>

      <div class="col-md-4">
        <div class="text-center">
          <i style="font-size:90px; line-height:1em;" class="ion-android-notifications"></i>
          <h3>通知系统 (Notice)</h3>
        </div>
        <p class="text-center" style="max-width:100%;">
          用户对你关注的内容或发布内容，点赞、评论等操作后，你将收到相关通知 <br>
          当然，通知不仅限于此 <br>
          <br>
        </p>
      </div>
    </div>

    <div class="row">
      <div class="col-md-4">
        <div class="text-center">
          <i style="font-size:90px; line-height:1em;" class="ion-ios-flower"></i>
          <h3>公园 (Timeline)</h3>
        </div>
        <p class="text-center" style="max-width:100%;">
          短平快的信息流，类似于 朋友圈、微博 <br>
          用记可以发布一些与社区主题相关的动态 <br>
          动态可以是图片、文字、视频 <br>
          <br>
        </p>
      </div>

      <div class="col-md-4">
        <div class="text-center">
          <i style="font-size:90px; line-height:1em;" class="ion-ios-bookmarks"></i>
          <h3>文章 (Article) <small>开发中</small></h3>
        </div>
        <p class="text-center" style="max-width:100%;">
          大型、中型社区使用文章做为内容媒体，用于发布社区的 新闻时事、评论观察 等等
          <br>
          <br>
          <br>
        </p>
      </div>

      <div class="col-md-4">
        <div class="text-center">
          <i style="font-size:90px; line-height:1em;" class="ion-quote"></i>
          <h3>话题 (Topic) <small>开发中</small></h3>
        </div>
        <p class="text-center" style="max-width:100%;">
          在社区里就一个话题进行深入的讨论 <br>
          不限时间也不限地点 <br>
          对精彩的内容你可以点赞，对不认同的主张你可以提出自己的看法 <br>
          <br>
        </p>
      </div>
    </div>

    <div class="row">
      <div class="col-md-4">
        <div class="text-center">
          <i style="font-size:90px; line-height:1em;" class="ion-ios-calendar"></i>
          <h3>活动 (Activity) <small>开发中</small></h3>
        </div>
        <p class="text-center" style="max-width:100%;">
          不管是线上还是线下活动，都是一个社群必不可以的内容 <br>
          组织线下活动，让社群成员相互认识
          <br>
        </p>
      </div>

      <div class="col-md-4">
        <div class="text-center">
          <i style="font-size:90px; line-height:1em;" class="ion-chatboxes"></i>
          <h3>消息 (Message) <small>开发中</small></h3>
        </div>
        <p class="text-center" style="max-width:100%;">
          除了异步的交流，即时聊天通信也是必不可少的 <br>
          即时的聊天通信不仅高效便捷，最重要的是这些消息是不在社区公开的 <br>
          <br>
        </p>
      </div>

      <div class="col-md-4">
        <div class="text-center">
          <i style="font-size:90px; line-height:1em;" class="ion-android-cart"></i>
          <h3>商店 (store) <small>开发中</small></h3>
        </div>
        <p class="text-center" style="max-width:100%;">
          当社区非常活跃之后，有了很多忠实用户 <br>
          在此之前肯定是付出了很多，现在你在考虑如何赢利以供社区持续发展？ <br>
          那就卖点社区成员们喜爱的商品吧 ~<br>
          <br>
        </p>
      </div>
    </div>

  </div>
</div>
@endsection
