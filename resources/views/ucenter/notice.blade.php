@extends('layouts.home')

@section('content')
<div class="container pt-4">
    <div class="row">
        <!-- LG 3 -->
        <div class="col-lg-3">
            @include('ucenter._sidebar', ['user' => Auth::user()->user()])
        </div>

        <!-- LG 9 -->
        <div class="col-lg-9">
            @include('ucenter._tabsNav')

            <div class="pt-4">
                <!-- Notices -->
                <ul class="list-group">
                    @if($notices->count())
                        @foreach ($notices as $notice)
                            @include('ucenter._notice')
                        @endforeach
                        {!! $notices->render() !!}
                    @else
                        @include('common.nodata')
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
