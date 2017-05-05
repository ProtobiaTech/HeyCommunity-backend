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
        <a class="btn btn-large btn-success" href="{{url('topic/create')}}" style="margin-bottom: 5px" data-method ="POST">  发布  </a>
      </div>
      <div class="list-group list-topic">
        @foreach ($topics as $topic)
          <div class="list-group-item">
            <img class="avatar" src="{{ $topic->author->avatar }}">
            <div class="pull-left body">
              <div class="title">
                {{ $topic->title }}
                <span class="info hidden-xs-down">
                  <a data-method="POST" href="{{url('topic/thumb-up',[$topic->id,'up'])}}"> &nbsp;{{$topic->thumb_up_num}}赞&nbsp; </a>/ <a href="{{url('topic/show',$topic->id)}}">&nbsp;{{$topic->comment_num}} 评&nbsp; </a>/ <a href="{{url('topic/show',$topic->id)}}">&nbsp;{{$topic->view_num}} 阅 &nbsp; </a>| &nbsp;
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
