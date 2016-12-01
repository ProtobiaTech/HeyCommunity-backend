@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-2">
            @include('dashboard.guide._sidenav')
        </div>

        <div class="col-sm-10">
            <div id="section-breadcrumb">
                <ol class="breadcrumb">
                    <li><a href="{{ url('/dashboard') }}">HeyCommunity</a></li>
                    <li><a href="{{ url('/dashboard/guide') }}">{{ trans('dashboard.Guide') }}</a></li>
                    <li class="active">{{ trans('dashboard.Getting started') }}</li>
                </ol>
            </div>

            <div id="section-mainbody">
                <p>
                    HeyCommunity 是线上社区解决方案，为社区构建一个独立的、功能强大的线上交流平台。
                </p>
                <p>
                    你正在使用的是云社区，其主要使用场景在于微信中。<br>
                    通过公众号导航菜单链接进入到云社区，这是最基本的入口。社区的内容被分享在朋友圈，这个分享链接也是一个很好的进入社区的方式。<br>
                    你的微信公众号评论之后，你可以把云社区与之相关联。关联之后，使用你自己的公众号让用户授权登录；如果用户关注了公众号，社区的消息通知还能通过公众号下发，以增加用户粘度。
                </p>
                <br>
                <br>
            </div>
        </div>
    </div>
</div>
@endsection

