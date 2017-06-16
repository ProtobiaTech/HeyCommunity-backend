@extends('layouts.home')

@section('content')
    <div class="container pt-4">
        <div class="row">
            <!-- LG 3 -->
            <div class="col-lg-3">
                @include('ucenter._sidebar', ['user' => $user])
            </div>

            <!-- LG 3 -->
            <div class="col-lg-9">
                @include('user._tabsNav')

                <div class="pt-4">
                    <!-- Topic -->
                    <ul class="list-group media-list media-list-stream mb-4">
                        @if($timelines->count())
                            @foreach ($timelines as $timeline)
                                @include('common.timeline')
                            @endforeach
                        @else
                            @include('common.nodata')
                        @endif
                    </ul>

                    <br>
                    <div>
                        @include('common.pagination', ['paginator' => $timelines])
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
