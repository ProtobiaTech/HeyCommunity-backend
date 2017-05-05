@extends('layouts.home')

@section('content')
    <div class="container-fluid">
        <div class="row page-title-row">
            <div class="col-md-12" style="margin-top: 15px">
                <h3>Edit Comment</h3>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">

                    <div class="panel-body">

                        @include('common.error')
                        @include('common.success')

                        <form class="form-horizontal" role="form" method="POST" action="{{url('topic/update-comment',$comment->id)}}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="_method" value="PUT">

                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="content" class="col-md-2 control-label">
                                            {{$comment->content}}
                                        </label>
                                        <div class="col-md-10">
                                            <textarea class="form-control" name="content" rows="14" id="content">{{ $comment->content }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fa fa-disk-o"></i>
                                    Update Comment
                                </button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

@stop