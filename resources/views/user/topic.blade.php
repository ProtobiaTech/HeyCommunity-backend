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
                        @foreach ($topics as $topic)
                            @include('ucenter._topic')
                        @endforeach

                        {!! $topics->render() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
