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
                    <div class="list-group list-topic">
                        @if($topics->count())
                            @foreach ($topics as $topic)
                                @include('common.topic')
                            @endforeach
                        @else
                            @include('common.nodata')
                        @endif
                    </div>

                    <br>
                    <div>
                        @include('common.pagination', ['paginator' => $topics])
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
