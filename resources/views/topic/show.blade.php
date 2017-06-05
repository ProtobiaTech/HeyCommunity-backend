@extends('layouts.home')

@section('content')
    <div id="hc-topic" class="container page-topic-show pt-4">
        <div class="row">
            <div class="col-lg-2">
                <hr style="margin-top:0;">

                <a class="btn btn-block btn-secondary" href="{{ URL::previous() }}"><i
                            class="pull-left fa fa-chevron-left" style="line-height:1.25"></i> 返回</a>
                <br>

                <a class="btn btn-block btn-secondary"
                   href="javascript:$('.form-topic-comment .input-content').focus();">
                    <i class="pull-left fa fa-reply" style="line-height:1.25"></i> 回复
                </a>

                <a class="btn btn-block btn-secondary"
                   onclick="event.preventDefault();
                   document.getElementById('topic-thumb-up').submit();"
                ><i class="pull-left fa fa-thumbs{{ $topic->thumb_value == 1 ? '' : '-o' }}-up" style="line-height:1.25"></i> 点赞</a>
                <a class="btn btn-block btn-secondary"
                   onclick="event.preventDefault();
                   document.getElementById('topic-thumb-down').submit();"
                ><i class="pull-left fa fa-thumbs{{ $topic->thumb_value == 2 ? '' : '-o' }}-down" style="line-height:1.25"></i> 点踩</a>
                <a class="btn btn-block btn-secondary"
                   onclick="event.preventDefault();
                   document.getElementById('topic-star-form').submit();"
                ><i class="pull-left fa fa-star{{ $topic->is_star ? '' : '-o' }}" style="line-height:1.25"></i> 收藏</a>

                <div style="display: none">
                    {!! Form::open(array('url' => '/topic/set-thumb', 'method' => 'POST', 'id' => 'topic-thumb-up')) !!}
                    {{ csrf_field() }}
                    {!! Form::hidden('id', $topic->id) !!}
                    {!! Form::hidden('value', 'up') !!}
                    {!! Form::close() !!}
                </div>

                <div style="display: none">
                    {!! Form::open(array('url' => '/topic/set-thumb', 'method' => 'POST', 'id' => 'topic-thumb-down')) !!}
                    {{ csrf_field() }}
                    {!! Form::hidden('id', $topic->id) !!}
                    {!! Form::hidden('value', 'down') !!}
                    {!! Form::close() !!}
                </div>

                <div style="display: none">
                    {!! Form::open(array('url' => '/topic/set-star', 'method' => 'POST', 'id' => 'topic-star-form')) !!}
                    {{ csrf_field() }}
                    {!! Form::hidden('id', $topic->id) !!}
                    {!! Form::close() !!}
                </div>
            </div>

            <!-- LG 7 -->
            <div class="col-lg-7">
                <div class="card">
                    <div class="card-block">
                        <h3>{{ $topic->title }}</h3>
                        <div>
                            <span>
                                @lang('dashboard.Node') /
                                @if($topic->node)
                                    <a href="/topic?node={{ $topic->node->name }}">{{ $topic->node->name }}</a>
                                @endif
                            </span>

                            <div class="pull-right">
                                {{ $topic->created_at->format('Y-m-d H:i:s') }}
                            </div>
                        </div>
                        <br>

                        <p class="content">{!! $topic->content !!}</p>

                        <div class="mb-2 form-topic-comment" style="margin-bottom:1rem !important;">
                            {!! Form::open(array('url' => '/topic/store-comment', 'method' => 'POST')) !!}
                            {{ csrf_field() }}
                            {!! Form::hidden('topic_id', $topic->id) !!}
                            {!! Form::hidden('topic_comment_id', 0, ['id' => 'parent-id']) !!}

                            <div class="input-group">
                                <input type="text" name="content" class="form-control input-content" placeholder="">
                                <div class="input-group-btn">
                                    <button type="submit" class="btn btn-secondary">
                                        <span class="icon icon-paper-plane"></span>
                                    </button>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>

                        <hr style="margin-top:0;">

                        @if ($comments)
                            <ul class="media-list mb-2 media-body list-group media-list-stream">
                                @foreach ($comments as $index => $comment)
                                    @include('topic._comment')
                                @endforeach
                                {!! $comments->render() !!}
                            </ul>
                        @endif
                    </div>
                </div>
            </div>

            <!-- LG 3 -->
            <div class="col-lg-3 hidden-xs-down">
                @include('common.userAvatarCard', ['user' => $topic->author])
                @include('common.userInfoCard', ['user' => $topic->author])
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function replyOne(username, parentId) {
            $('#parent-id').val(parentId);
            replyContent = $(".input-content");
            oldContent = replyContent.val();
            prefix = "@" + username + " ";
            newContent = '';

            if (oldContent.length > 0) {
                if (oldContent != prefix) {
                    newContent = oldContent + "\n" + prefix;
                }
            } else {
                newContent = prefix
            }
            replyContent.focus();
            replyContent.val(newContent);
        }
    </script>
@endsection
