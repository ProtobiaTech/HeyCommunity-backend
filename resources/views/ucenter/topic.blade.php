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
                <!-- Topic -->
                <div class="list-group list-topic">
                    <?php $topics = \App\Topic::get(); ?>
                    @foreach ($topics as $topic)
                        <div class="list-group-item">
                            <img class="avatar" src="{{ $topic->author->avatar }}">
                            <div class="pull-left body">
                                <div class="title">
                                    <a href="{{ url('/topic/show', ['id' => $topic->id]) }}">{{ $topic->title }}</a>
                                    <span class="info hidden-xs-down">
                                        {{ $topic->thumb_up_num }}&nbsp; /
                                        &nbsp;{{ $topic->comment_num }}&nbsp; /
                                        &nbsp;{{ $topic->view_num }} &nbsp;&nbsp;&nbsp;&nbsp;
                                        {{ $topic->created_at->format('m-d') }}
                                    </span>
                                </div>

                                <div class="content">
                                    {{ mb_substr($topic->content, 0, 200) }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
