@extends('layouts.home')

@section('content')
    <div class="container-fluid">
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

                        <form class="form-horizontal" role="form" method="POST" action="/topic/edit/{{$topic_id}}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div id="section-mainbody">
                                <p class="h3 text-center">我的话题</p>

                                <table class="table table-striped">
                                    <tr>
                                        <th style="width:10em;">Title </th>
                                        <td>{{$title}}</td>
                                    </tr>
                                    <tr>
                                        <th style="width:10em;">Content </th>
                                        <td>{{$content}}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="row">

                                <div class="col-md-4 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="fa fa-disk-o"></i>
                                        Edit Topic
                                    </button>
                                </div>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

@stop