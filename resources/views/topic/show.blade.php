@extends('layouts.home')

@section('content')
<div id="hc-topic" class="container page-topic-show pt-4">
  <div class="row">
    <div class="col-lg-2">
      <hr style="margin-top:0;">

      <a class="btn btn-block btn-secondary" href="{{ URL::previous() }}"><i class="pull-left fa fa-chevron-left" style="line-height:1.25"></i> 返回</a>
      <br>

      <a class="btn btn-block btn-secondary" href="{{ URL::previous() }}"><i class="pull-left fa fa-reply" style="line-height:1.25"></i> 回复</a>
      <a class="btn btn-block btn-secondary" href="{{ URL::previous() }}"><i class="pull-left fa fa-thumbs-o-up" style="line-height:1.25"></i> 点赞</a>
      <a class="btn btn-block btn-secondary" href="{{ URL::previous() }}"><i class="pull-left fa fa-thumbs-o-down" style="line-height:1.25"></i> 点踩</a>
      <a class="btn btn-block btn-secondary" href="{{ URL::previous() }}"><i class="pull-left fa fa-star-o" style="line-height:1.25"></i> 收藏</a>
    </div>

    <!-- LG 7 -->
    <div class="col-lg-7">
      <div class="card">
        <div class="card-block">
          <h3>{{ $topic->title }}</h3>
          <div>
            <span>Topic / Category</span>

            <div class="pull-right">
              {{ $topic->created_at->format('Y-m-d H:i:s') }}
            </div>
          </div>
          <br>

          <p class="content">{!! $topic->content !!}</p>
        </div>
      </div>
    </div>

    <!-- LG 3 -->
    <div class="col-lg-3 hidden-xs-down">
      @include('common.userAvatarCard', ['user' => $topic->author])
      @include('common.userInfoCard', ['user' => $topic->author])
    </div>
  </div>
</div>
@endsection
