@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="text-center">
        <h2>Hey Community</h2>
    </div>

    <!-- Login panel -->
    <div class="row" style="margin-top:30px;">
        @if (Auth::tenant()->guest())
            <div class="text-center">
                Please <a href="{{ route('admin.auth.login') }}">Login</a>
            </div>
        @else
            <div class="col-sm-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        User State
                    </div>
                    <div class="panel-body">
                        Total: {{ $users->count() }}
                    </div>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Timeline State
                    </div>
                    <div class="panel-body">
                        Total: {{ $timelines->count() }}
                    </div>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Activity State
                    </div>
                    <div class="panel-body">
                        Total:: {{ $activities->count() }}
                    </div>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Date Panel
                    </div>
                    <div class="panel-body">
                        deving
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
