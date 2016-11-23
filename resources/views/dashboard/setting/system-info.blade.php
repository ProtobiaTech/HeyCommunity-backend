@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-2">
            @include('dashboard.setting._sidenav')
        </div>

        <div class="col-sm-9">
            <div id="section-breadcrumb">
                <ol class="breadcrumb">
                    <li><a href="{{ url('/dashboard') }}">HeyCommunity</a></li>
                    <li><a href="{{ url('/dashboard/setting') }}">{{ trans('dashboard.Setting') }}</a></li>
                    <li class="active">{{ trans('dashboard.Community Info') }}</li>
                </ol>

                <div class="pull-right">
                    <a href="{{ url('dashboard/setting/edit-system-info') }}" class="btn btn-default btn-sm">{{ trans('dashboard.Edit') }}</a>
                </div>
            </div>

            <div id="section-mainbody">
                <p class="h3 text-center">{{ trans('dashboard.Community Info') }}</p>

                <table class="table table-striped">
                    <tr>
                        <th style="width:10em;">{{ trans('dashboard.Community Name') }}</th>
                        <td>{{ $system->community_name }}</td>
                    </tr>
                    <tr>
                        <th style="width:10em;">{{ trans('dashboard.Created At') }}</th>
                        <td>{{ $system->created_at }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

