@extends('layouts.home')

@section('content')
<div id="hc-topic" class="page-topic container pt-4">
  <div class="row">
    <!-- LG 3 -->
    <div class="col-lg-3 hidden-xs-down">
      <div class="card-tools">
        <a class="btn btn-primary btn-block" todo-href="{{url('topic/create')}}">@lang('hc.create topic')</a>
      </div>

      <div class="card card-nodes visible-md-block visible-lg-block mb-4">
        <div class="card-block">
          <h6 class="mb-3">@lang('节点列表')</h6>
          <div class="">
            @foreach ($topicNodes as $node)
              <div class="nodes-item">
                <span>{{ $node->name }}</span>
                @foreach ($node->children as $childNode)
                  <a href="">{{ $childNode->name }}</a>
                @endforeach
              </div>
            @endforeach
          </div>
        </div>
      </div>

      <div class="card card-tags visible-md-block visible-lg-block mb-4">
          <div class="card-block">
              <h6 class="mb-3">@lang('hc.we are discussing')</h6>
              <div class="tags">
                <span class="muted">@lang('hc.no content yet')</span>
                <!--
                <a href="" class="l1">苹果</a>
                <a href="" class="l2">马戏团</a>
                <a href="" class="l2">美国</a>
                <a href="" class="l1">美国</a>
                <a href="" class="l3">美国</a>
                <a href="" class="l1">美国</a>
                <a href="" class="l4">美国</a>
                <a href="" class="l4">美国</a>
                -->
              </div>
          </div>
      </div>
    </div>


    <!-- LG 9 -->
    <div class="col-lg-9">
      <div class="list-group list-topic">
        @foreach ($topics as $topic)
          <div class="list-group-item">
            <img class="avatar" src="{{ $topic->author->avatar }}">
            <div class="pull-left body">
              <div class="title">
                <a href="{{ url('/topic/show', ['id' => $topic->id]) }}">{{ $topic->title }}</a>
                <span class="info hidden-xs-down">
                  {{ $topic->thumb_up_num }}&nbsp; /
                  &nbsp;{{ $topic->comment_num }}&nbsp; /
                  &nbsp;{{ $topic->view_num }} &nbsp;&nbsp;&nbsp;&nbsp;
                  {{ $topic->created_at->format('m-d') }}
                </span>
              </div>
              <div class="content">
                {{ mb_substr($topic->content, 0, 200) }}
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </div>
</div>
@endsection
