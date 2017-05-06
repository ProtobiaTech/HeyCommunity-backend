@extends('layouts.home')

@section('content')
    <div class="container-fluid" >
        <div class="row">
            <div class="col-sm-10" style="float: none;display: block;margin-left: auto;margin-right: auto;">
                <div class="panel panel-default">

                    <div class="panel-body">
                        <div class=" col-sm-10 " style="margin-top: 15px;">
                            <h3>@lang('hey_web_info.topic_add')</h3>
                        </div>
                        @include('common.error')
                        @include('common.success')

                        <form class="form-horizontal" role="form" method="POST" action="{{url('topic/store')}}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            @include('topic._form')

                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fa fa-disk-o"></i>
                                    @lang('hey_web_info.topic_save')
                                </button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

@stop
