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
            @foreach([1,2,3,4] as $item)
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
            @endforeach
        @endif
    </div>
</div>
@endsection
