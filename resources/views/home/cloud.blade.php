@extends('layouts.default-home')

@section('content')
<div class="container content-container">
  <div id="getting-started">
    <br>
    <br>
    <div class="text-center">
      <h2>一分钟开启你的云社区</h2>
      <p class="sub-heading">
        以公众号作入口，在微信中运行云社区 <br>
        享受到 <em>微信授权登录</em> 和 <em>微信消息推送</em> 等功能带来的便捷
      </p>
    </div>
    <div class="row" id="first-step">
      <div class="col-md-6 step-desc">
        <div class="num">
          <img src="ionic-assets/img/docs/symbols/step-1@2x.png" width="52" height="52">
        </div>
        <div class="desc">
          <h3>注册云社区</h3>
          <p>
            花费一分钟的时间，认真填写右侧表单，然后点击提交 <br>
            提交后请检查表单是否有反馈错误信息，如果有，请修正后再次提交 <br>
            如果注册成功，请进入到第二步
          </p>
          <p>
            <i>
              <strong>注意:</strong>
              请如实填写管理员邮箱和管理员手机，我们会妥善保存不会透露给第三方，也不会向你发送垃圾信息 <br>
            </i>
            <i>
              <strong>提示:</strong>
              如暂无域名，域名字段可为空
            </i>
          </p>
        </div>
      </div>
      <div class="col-md-6 code">
        @if (Auth::tenant()->check())
          <div style="" class="text-center">
            <img src="ionic-assets/img/docs/symbols/ionic-checkmark.png" width="52" height="52">
            <div style="margin-top:20px;">
              你的社区 <strong>{{ Auth::tenant()->user()->site_name }}</strong> 已经创建成功 <br>
              请进行下一步操作
            </div>
          </div>
        @else
          {!! Form::open(array('url' => '/store-tenant', 'method' => 'post', 'class' => 'form form-horizontal')) !!}
            <div class="form-group {{ $errors->has('site_name') ? 'has-error' : '' }}">
                <label class="col-sm-3 control-label" for="title">应用名称</label>
                <div class="col-sm-9">
                    <input class="form-control" type="text" name="site_name" value="{{ old('site_name') }}" placeholder="应用名称">
                    @if ($errors->has('site_name'))
                      <span class="help-block">
                        {{ $errors->get('site_name')[0] }}
                      </span>
                    @endif
                </div>
            </div>

            <div class="form-group {{ $errors->has('domain') ? 'has-error' : '' }}">
                <label class="col-sm-3 control-label" for="title">域名</label>
                <div class="col-sm-9">
                    <div class="input-group">
                        <span class="input-group-addon" id="sizing-addon1">http://</span>
                        <input class="form-control" type="text" name="domain" value="{{ old('domain') }}" placeholder="site-domain.com">
                    </div>
                    @if ($errors->has('domain'))
                      <span class="help-block">
                        {{ $errors->get('domain')[0] }}
                      </span>
                    @endif
                </div>
            </div>

            <div class="form-group {{ $errors->has('sub_domain') ? 'has-error' : '' }}">
                <label class="col-sm-3 control-label" for="title">子域名</label>
                <div class="col-sm-9">
                    <div class="input-group">
                        <span class="input-group-addon" id="sizing-addon1">http://</span>
                        <input class="form-control" type="text" name="sub_domain" value="{{ old('sub_domain') }}" placeholder="sub-domain">
                        <span class="input-group-addon" id="sizing-addon1">.hey-community.com</span>
                    </div>
                    @if ($errors->has('sub_domain'))
                      <span class="help-block">
                        {{ $errors->get('sub_domain')[0] }}
                      </span>
                    @endif
                </div>
            </div>

            <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                <label class="col-sm-3 control-label" for="title">管理员邮箱</label>
                <div class="col-sm-9">
                    <input class="form-control" type="text" name="email" value="{{ old('email') }}" placeholder="hello@hey-community.com">
                    @if ($errors->has('email'))
                      <span class="help-block">
                        {{ $errors->get('email')[0] }}
                      </span>
                    @endif
                </div>
            </div>

            <div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
                <label class="col-sm-3 control-label" for="title">管理员手机</label>
                <div class="col-sm-9">
                    <input class="form-control" type="text" name="phone" value="{{ old('phone') }}" placeholder="17090402884">
                    @if ($errors->has('phone'))
                      <span class="help-block">
                        {{ $errors->get('phone')[0] }}
                      </span>
                    @endif
                </div>
            </div>

            <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                <label class="col-sm-3 control-label" for="title">管理员密码</label>
                <div class="col-sm-9">
                    <input class="form-control" type="password" name="password" value="" placeholder="管理员密码">
                    @if ($errors->has('password'))
                      <span class="help-block">
                        {{ $errors->get('password')[0] }}
                      </span>
                    @endif
                </div>
            </div>

            <div class="form-group {{ $errors->has('password_duplicate') ? 'has-error' : '' }}">
                <label class="col-sm-3 control-label" for="title">重复管理员密码</label>
                <div class="col-sm-9">
                    <input class="form-control" type="password" name="password_duplicate" value="" placeholder="管理员密码">
                    @if ($errors->has('password_duplicate'))
                      <span class="help-block">
                        {{ $errors->get('password_duplicate')[0] }}
                      </span>
                    @endif
                </div>
            </div>


            <div class="form-group">
                <div class="col-sm-9 col-sm-offset-3">
                    <button type="submit" class="btn btn-primary btn-block">提交</button>
                </div>
            </div>
          {!! Form::close() !!}
        @endif
      </div>
    </div>

    <div class="row">
      <div class="col-md-6 step-desc">
        <div class="num">
          <img src="ionic-assets/img/docs/symbols/step-2@2x.png" width="52" height="52">
        </div>
        <div class="desc">
          <h3>接入微信公众号 <small>(可跳过此步骤)</small></h3>
          <p>
            @if (Auth::tenant()->check())
              现在，
            @else
              完成第一步后，
            @endif
            登录<a href="https://mp.weixin.qq.com" target="_blank">微信公众平台</a>，在微信公众平台左侧导航区域点击 <strong>功能</strong> 栏目下的 <strong>自定义菜单</strong>
            进入到自定交菜单管理页面 <br>
            然后添加一个跳转到网页的菜单，作为社区的入口，
            @if (Auth::tenant()->check())
              网页地址为: <em>http://{{ Auth::tenant()->user()->sub_domain }}</em>
            @else
              该网页地址会在完成第二步之后显示在这里
            @endif
          </p>
          <p>
            如果你的公众号获得了 <strong>业务通知</strong> 和 <strong>页授权获取用户基本信息</strong> 接口，那你可以在云社区管理后台关联你的微信公众号 <br>
            关联公众号之后，将会使用你的公众号进行社区的 授权登录 和 消息推送
          </p>
          <i>
            更多关于公众号的知识请进入微信公众平台进行了解
          </i>
        </div>
      </div>
      <div class="col-md-6 code hidden-xs hidden-sm">
        <div class="text-center">
          <i class="ion-ios-body" style="font-size:120px; color:#666;"></i>
        </div>
      </div>
    </div>


    <!-- -->
    <div class="row">
      <div class="col-md-6 step-desc">
        <div class="num">
          <img src="ionic-assets/img/docs/symbols/step-3@2x.png" width="52" height="52">
        </div>
        <div class="desc">
          <h3>开始使用</h3>
          <p>
            祝贺你完成了所有工作，可能用了不止一分钟的时间？哈哈 ~ <br>
            现在你就可以使用这个线上社区了
          </p>
          <p>
            欢迎你加入我们 HeyCommunity 用户QQ群 (242078519)，一起交流社区运营知识和见解
          </p>
        </div>
      </div>
      <div class="col-md-6 code hidden-xs hidden-sm">
        <div class="text-center">
          <i class="ion-paper-airplane" style="font-size:80px; color:#666;"></i>
        </div>
      </div>
    </div>
  </div>


  <div id="getting-started-cont">
    <section class="container what-next">
      <hgroup>
        <h2>他们都在使用云社区</h2>
        <p class="hide">
          云社区
        </p>
      </hgroup>
      <style>
      #getting-started-cont .items {
        max-width: 100% !important;
        width: 100% !important;
      }
      #getting-started-cont .items .item {
        margin: 0;
        width: 33.3333%;
        max-width: 33.3333%;
        padding-left: 35px;
        padding-right: 35px;
      }

      @media (max-width:767px) {
        #getting-started-cont .items .item {
          width: 100%;
          max-width: 100%;
        }
      }
      </style>
      <div class="items row">
        <div class="item col-sm-4" style="padding-top:0;">
          <h3 class="text-center">海峡交通迷社区</h3>
          <p class="text-center">
            福建交通爱好者俱乐部 <br>
            曾经使用 Discuz! 论坛用于俱乐部交流，MediaWiki 做为百科资料库。现在使用 HeyCommunity 用于俱乐部成员日常社交
          </p>
          <p class="text-center">
            多平台支持，良好的移动操作体验。随手拍张照片即可分享在社区中。产品免费、开源，便于日后私有化部署和二次开发
          </p>
          <span class="hide">
            <i class="ion-qr-scanner"></i> &nbsp;
            扫码进入该社区
          </span>
        </div>
        <div class="item col-sm-4" style="padding-top:0;">
          <h3 class="text-center">HEY 赣州</h3>
          <p class="text-center">
            赣州实名制同城社区 <br>
            三四线人口流动性较低，城市居民安生立身过着平静的生活。 实名同城社区是市民在现实生活的延伸
          </p>
          <p class="text-center">
            运营微信服务号积攒粉丝，通过公众号和朋友圏的链接做为社区入口，让用户便捷地在圈子里交流。
            然后引导用户下载 App, 获取更丰富的功能和更流畅的体验
          </p>
          <span class="hide">
            <i class="ion-qr-scanner"></i> &nbsp;
            扫码进入该社区
          </span>
          <br>
          <br>
        </div>
        <div class="item col-sm-4" style="padding-top:0;">
          <h3 class="text-center">HeyCommunity DEMO</h3>
          <p class="text-center">
            HeyCommunity 产品演示社区 <br>
            通过这个社区，可以体验到产品的各种功能
          <p>
          <p class="text-center">
            它可以运行在浏览器中，在微信中打开还可以体验到授权登录和消息推送功能，它还是个 App 可以安装在 iOS / Android / windows phone 等一切手机中
          </p>
          <p class="text-center">
            但是，请不要发布不恰当或无意义的内容 <br>
          </p>
          <span class="hide">
            <i class="ion-qr-scanner"></i> &nbsp;
            扫码进入该社区
          </span>
          <br>
          <br>
        </div>
      </div>
    </section>
    <div style="height:60px;"></div>
  </div>
</div>

@endsection
