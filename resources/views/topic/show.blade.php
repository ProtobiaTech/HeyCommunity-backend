@extends('layouts.home')

@section('content')
    <div id="hc-topic" class="container-fluid page-topic">
        <div class="row page-title-row">
            <div class="col-md-12" style="margin-top: 15px">
                <h3>&nbsp;</h3>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">

                    <div class="panel-body">

                        @include('common.error')

                        <form class="form-horizontal" role="form" method="POST" action="{{url('topic/edit',$topic->id)}}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div id="section-mainbody">
                                <p class="h3 text-center">{{$topic->title}}</p>
                                <div class="text-right">
                                    <span class="pull-right">{{$topic->created_at}}</span>
                                </div>
                                <div class="text-right">{{$topic->author->nickname}}
                                    <span >{{$topic->thumb_up_num}} 赞&nbsp;<span class="separator">/</span>
                                        &nbsp;{{$topic->thumb_down_num}} 踩&nbsp;
                                        <span class="separator">/</span>
                                        &nbsp;{{$topic->view_num}} 阅&nbsp;<span class="separator">/</span>
                                        &nbsp;1 收藏</span>
                                </div>
                                <hr>
                                <p class="content">{{$topic->content}}</p>
                            </div>
                            @if(Auth::user()->check() && Auth::user()->user()->id == $topic->user_id)
                                <div class="row">
                                    <div class="col-md-4 col-md-offset-4">
                                        <button type="submit" class="btn btn-primary btn-lg">
                                            <i class="fa fa-disk-o"></i>
                                            Edit Topic
                                        </button>
                                    </div>
                                </div>
                            @endif

                        </form>
                        <hr/>
                        <div class="list-group list-topic" style="margin-top: 30px">
                            <h6 padding-left="" padding-right="" pading-top="">评论 <small>({{$topic->comment_num}})</small></h6>

                            @foreach($topic->comments as $comment)

                                <div class="list-group-item">
                                    <img class="avatar" src="{{$comment->author->avatar}}">
                                    <div class="pull-left body">
                                        <div class="title">
                                            {{$comment->author->nickname}}
                                            <span class="info hidden-xs-down">{{$comment->created_at->diffForHumans()}}</span>
                                        </div>
                                        <div class="content">
                                            {{$comment->content}}<br/>
                                            @if(Auth::user()->check() && Auth::user()->user()->id == $comment->user_id)
                                                <a class="btn btn-info btn-sm" href="{{url('topic/edit-comment',$comment->id)}}" role="button" style="margin-top: 10px">修改评论</a>
                                            @endif
                                        </div>
                                    </div>
                                    </p>
                                </div>
                            @endforeach
                        </div>
                                <form id="comment" method="post" action="{{url('topic/store-comment')}}">
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label for="tcontent" class="control-label" id="comment-title">Content:</label>
                                                <textarea class="form-control" id="content" name="content" rows="4"></textarea>
                                            {!! csrf_field() !!}
                                            <input type="hidden" id="topic_id" name="topic_id" value="{{$topic->id}}">
                                        </div>
                                        <div class="col-md-12">
                                            <button type="submit" id="" class="btn btn-primary" value="add">提交评论</button>
                                        </div>
                                    </div>
                                </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop