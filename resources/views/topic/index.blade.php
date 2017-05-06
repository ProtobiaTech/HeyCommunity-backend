@extends('layouts.home')

@section('content')
<div id="hc-topic" class="page-topic container pt-4">
  <div class="row">
    <!-- LG 3 -->
    <div class="col-lg-3 hidden-xs-down">
      @include('common._welcome_login_left')

      @include('common._about_left')

      @include('common._photos_left')

    </div>


    <!-- LG 9 -->
    <div class="col-lg-9">
      <div class="pull-right body">
        <a class="btn btn-large btn-success" href="{{url('topic/create')}}" style="margin-bottom: 5px" data-method ="POST">  @lang('hey_web_info.topic_publish')  </a>
      </div>
      <div class="list-group list-topic">
        @foreach ($topics as $topic)
          <div class="list-group-item">
            <img class="avatar" src="{{ $topic->author->avatar }}">
            <div class="pull-left body">
              <div class="title">
                <a href="{{url('topic/show',$topic->id)}}">{{ $topic->title }}</a>
                <span class="info hidden-xs-down">
                   &nbsp;{{$topic->thumb_up_num}}&nbsp; @lang('hey_web_info.thumb_up')&nbsp; / {{$topic->comment_num}}&nbsp;
                    @lang('hey_web_info.comment_short')&nbsp; /
                    &nbsp;{{$topic->view_num}} &nbsp;@lang('hey_web_info.view') &nbsp; | &nbsp;
                  {{ $topic->created_at->format('m-d') }}
                </span>
              </div>
              <div class="content">
                {{ mb_substr($topic->content, 0, 200) }}
              </div>
            </div>
            </p>
          </div>
        @endforeach
      </div>
    </div>
  </div>
</div>
@endsection
