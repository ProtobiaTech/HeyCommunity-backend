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
                        @if (env('WECHATPA_ENABLE') === true)
                            <td>Yes</td>
                        @else
                            <td>No</td>
                        @endif
                    </tr>
                    <tr>
                        <th style="width:10em;">App ID</th>
                        @if (env('WECHATPA_APPID'))
                            <td>{{ (substr(env('WECHATPA_APPID'), 0, -8)) . '********' }}</td>
                        @else
                            <td>Null</td>
                        @endif
                    </tr>
                    <tr>
                        <th style="width:10em;">App Secret</th>
                        @if (env('WECHATPA_SECRET'))
                            <td>{{ (substr(env('WECHATPA_SECRET'), 0, -12) . '************') }}</td>
                        @else
                            <td>Null</td>
                        @endif
                    </tr>
                    <tr>
                        <th style="width:10em;">{{ trans('dashboard.TempNotice') }} Id</th>
                        @if (env('WECHATPA_TEMP_NOTICE_ID'))
                            <td>{{ (substr(env('WECHATPA_TEMP_NOTICE_ID'), 0, -12) . '************') }}</td>
                        @else
                            <td>Null</td>
                        @endif
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

