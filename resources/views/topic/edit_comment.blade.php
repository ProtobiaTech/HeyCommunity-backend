@extends('layouts.home')

@section('content')
    <div class="container-fluid">


        <div class="row">
            <div class=" col-sm-10 " style="float: none;display: block;margin-left: auto;margin-right: auto;">

                <div class="panel panel-default">
                    <div class="panel-body">
                        @include('common.error')
                        @include('common.success')
                            <div class="col-sm-11 col-sm-offset-1" style="margin-top: 15px">
                                <h3>@lang('hey_web_info.comment_edit')</h3>
                            </div>
                        <form class="form-horizontal" role="form" method="POST" action="{{url('topic/update-comment',$comment->id)}}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="_method" value="PUT">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="content" class="col-md-2 control-label">
                                            @lang('hey_web_info.comment_content')
                                        </label>
                                        <div class="col-md-12">
                                            <textarea class="form-control" name="content" rows="14" id="content">{{ $comment->content }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fa fa-disk-o"></i>
                                    @lang('hey_web_info.comment_update')
                                </button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

@stop