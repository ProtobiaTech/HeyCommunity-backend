@extends('layouts.home')

@section('content')
    <div id="hc-topic" class="container-fluid page-topic">
        <div class="row page-title-row">
            <div class="col-md-12" style="margin-top: 15px">
                <h3>&nbsp;</h3>
            </div>
        </div>

        <div class="row">
            <div class=" col-sm-10 " style="float: none;display: block;margin-left: auto;margin-right: auto;">
                <div class="panel panel-default">

                    <div class="panel-body">

                        @include('common.error')



                            <div id="section-mainbody">
                                <p class="h3 text-center">{{$topic->title}}</p>
                                <div class="text-right">
                                    <span class="pull-right">{{$topic->created_at}}</span>
                                </div>
                                <div>
                                    <span class="form-inline text-right" style="float: right">
                                        <span style="margin-right: 20px;">{{$topic->author->nickname}}</span>
                                            <form method="post" id="thumb_form" action="{{url('topic/set-thumb')}}">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="hidden" name="value" id="thumb_value_id" value="up">
                                                <input type="hidden" name="id" id="thumb_value_id" value="{{$topic->id}}">
                                                {{$topic->thumb_up_num}}
                                                <button id="btn_up" type="submit" class="btn btn-link btn-xs"> @lang('hey_web_info.thumb_up') </button>
                                                <span class="separator">/</span>
                                                {{$topic->thumb_down_num}}
                                                <button id="btn_down" type="submit" class="btn btn-link btn-xs"> @lang('hey_web_info.thumb_down') </button>
                                            </form>
                                        <span class="separator">/</span>
                                        &nbsp;{{$topic->view_num}} &nbsp;@lang('hey_web_info.view')&nbsp;&nbsp;<span class="separator">/</span>
                                        &nbsp;1 @lang('hey_web_info.favorite')
                                    </span>
                                </div>
                                <br/>
                                <hr>
                                <p class="content">{{$topic->content}}</p>
                            </div>
                            <form class="form-horizontal" role="form" method="POST" action="{{url('topic/edit',$topic->id)}}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                @if(Auth::user()->check() && Auth::user()->user()->id == $topic->user_id)
                                    <div class="row">
                                        <div class="col-md-4 col-md-offset-4">
                                            <button type="submit" class="btn btn-primary btn-lg">
                                                <i class="fa fa-disk-o"></i>
                                                @lang('hey_web_info.topic_edit')
                                            </button>
                                        </div>
                                    </div>
                                @endif
                            </form>
                        <hr/>
                        <div class="list-group list-topic" style="margin-top: 30px">
                            <h6 padding-left="" padding-right="" pading-top="">@lang('hey_web_info.comment_long') <small>({{$topic->comment_num}})</small></h6>

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
                                                <a class="btn btn-info btn-sm" href="{{url('topic/edit-comment',$comment->id)}}" role="button" style="margin-top: 10px">@lang('hey_web_info.comment_edit')</a>
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
                                            <button type="submit" id="" class="btn btn-primary" value="add">@lang('hey_web_info.comment_publish')</button>
                                        </div>
                                    </div>
                                </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('bootstrap-assets/js/jquery.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $("#btn_up").click(function(){
                $("#thumb_value_id").val("up");
                $("#thumb_form").submit(function(e){
                });
            });
            $("#btn_down").click(function(){
                $("#thumb_value_id").val("down");
                $("thumb_form").submit();
            });
        });
    </script>
@stop