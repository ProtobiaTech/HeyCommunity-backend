@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-2">
            @include('dashboard.topic._sidenav')
        </div>

        <div class="col-sm-10">
            <div id="section-breadcrumb">
                <ol class="breadcrumb">
                    <li><a href="{{ url('/dashboard') }}">HeyCommunity</a></li>
                    <li><a href="{{ url('/dashboard/topic') }}">{{ trans('dashboard.Topic') }}</a></li>
                    <li class="active">{{ trans('dashboard.Nodes') }}</li>
                </ol>
            </div>

            <div id="section-mainbody">
                {{ trans('dashboard.Coming soon') }}
            </div>
        </div>
    </div>
</div>
@endsection

