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
                    <li class="active">{{ trans('dashboard.WeChat PA Info') }}</li>
                </ol>

                <div class="pull-right">
                    <a href="{{ url('dashboard/setting/edit-wechat-pa') }}" class="btn btn-default btn-sm">{{ trans('dashboard.Edit') }}</a>
                </div>
            </div>

            <div id="section-mainbody">
                <p class="h3 text-center">{{ trans('dashboard.WeChat Public Account Info') }}</p>

                <table class="table table-striped">
                    <tr>
                        <th style="width:10em;">{{ trans('dashboard.Enabled') }}</th>
                        <td>{{ $system->enable_wechat_pa ? 'Yes' : 'No'}}</td>
                    </tr>
                    <tr>
                        <th style="width:10em;">App ID</th>
                        @if ($system->wx_app_id)
                            <td>{{ (substr($system->wx_app_id, 0, -8) . '********') }}</td>
                        @else
                            <td>null</td>
                        @endif
                    </tr>
                    <tr>
                        <th style="width:10em;">App Secret</th>
                        @if ($system->wx_app_secret)
                            <td>{{ (substr($system->wx_app_secret, 0, -12) . '************') }}</td>
                        @else
                            <td>null</td>
                        @endif
                    </tr>
                    <tr>
                        <th style="width:10em;">{{ trans('dashboard.TempNotice') }} Id</th>
                        @if ($system->wx_temp_notice_id)
                            <td>{{ (substr($system->wx_temp_notice_id, 0, -12) . '************') }}</td>
                        @else
                            <td>null</td>
                        @endif
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

