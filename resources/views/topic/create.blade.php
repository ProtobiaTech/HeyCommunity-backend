@extends('layouts.home')

@section('content')
    <div class="container-fluid">
        <div class="row page-title-row">
            <div class="col-md-12" style="margin-top: 15px">
                <h3>Add New Topic</h3>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">

                    <div class="panel-body">

                        @include('common.error')

                        <form class="form-horizontal" role="form" method="POST" action="{{url('topic/store')}}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            @include('topic._form')

                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fa fa-disk-o"></i>
                                    Save New Topic
                                </button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

@stop
