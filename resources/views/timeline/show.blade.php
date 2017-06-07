@extends('layouts.home')

@section('content')
    <div class="container pt-4">
        <div class="row">
            <div class="col-lg-2 hidden-sm-down hidden-md-down hidden-xs-down">
                <hr style="margin-top:0;">

                <a class="btn btn-block btn-secondary" href="{{ url('/timeline') }}"><i
                            class="pull-left fa fa-chevron-left" style="line-height:1.25"></i> 返回</a>
                <br>

                <a class="btn btn-block btn-secondary"
                   href="javascript:$('.form-timeline-comment .input-content').focus();"><i
                            class="pull-left fa fa-reply" style="line-height:1.25"></i> 回复</a>
                <a class="btn btn-block btn-secondary"
                   onclick="event.preventDefault();
                 document.getElementById('timeline-like-form').submit();">
                    <i class="pull-left fa fa-heart{{ $timeline->isLike ? '' : '-o' }}" style="line-height:1.25;"></i>
                    喜欢
                    <div style="display: none">
                        {!! Form::open(array('url' => '/timeline/set-like', 'method' => 'POST', 'id' => 'timeline-like-form')) !!}
                        {{ csrf_field() }}
                        {!! Form::hidden('id', $timeline->id) !!}
                        {!! Form::close() !!}
                    </div>
                </a>
                <!--
                <a class="btn btn-block btn-secondary" href="#"><i class="pull-left fa fa-star-o" style="line-height:1.25"></i> 收藏</a>
                -->
            </div>

            <!-- LG 7 -->
            <div class="col-lg-7 offset-l-1">
                <ul class="list-group media-list media-list-stream mb-4">
                    <li class="media list-group-item p-4">
                        <a class="media-object d-flex align-self-start mr-3"
                           href="{{ url('/user/profile/' . $timeline->author->id) }}"><img
                                    class="media-object d-flex align-self-start mr-3"
                                    src="{{ $timeline->author->avatar }}"></a>
                        <div class="media-body">
                            <div class="media-body-text">
                                <div class="media-heading">
                                    <small class="float-right text-muted">{{ $timeline->created_at->format('h-d H:i:m') }}</small>
                                    <small class="float-right text-muted">
                                        <i class="fa fa-fire"></i>
                                        <span>{{ $timeline->like_num + $timeline->comment_num * 2 }}</span>
                                        &nbsp;&nbsp;
                                    </small>
                                    <a href="{{ url('/user/profile/' . $timeline->author->id) }}">
                                        <h6>{{ $timeline->author->nickname }}</h6></a>
                                </div>

                                <!-- Keywords -->
                                @if($timeline->keywords->count())
                                    <div class="media-body-actions">
                                        <strong>@lang('dashboard.Keyword')</strong>:
                                        @foreach($timeline->keywords as $keyword)
                                            <button class="btn btn-link btn-xs" href="/timeline?keyword={{ $keyword->name }}">{{ $keyword->name }}</button>
                                        @endforeach
                                    </div>
                                @endif

                                <p>{{ $timeline->content }}</p>
                                @if ($timeline->images)
                                    <div class="media-body-inline-grid" data-grid="images">
                                        <?php $timelineImgs = $timeline->getImgs(); ?>
                                        @foreach ($timelineImgs as $image)
                                            <div style="display: none">
                                                <img data-action="zoom" data-width="100%" src="{{ $image->uri }}">
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                                {{--
                                <div class="mb-2 text-right">
                                  <!-- <a class="btn btn-default btn-xs"><i class="fa fa-heart" style="color:red;"></i></a> -->
                                  <a style="font-size:1rem;" class="btn btn-default btn-xs" href="#"><i class="fa fa-comment" style="color:#333"></i></a>
                                </div>
                                --}}

                                <div class="mb-2 form-timeline-comment" style="margin-bottom:1rem !important;">
                                    {!! Form::open(array('url' => '/timeline/store-comment', 'method' => 'POST')) !!}
                                    {{ csrf_field() }}
                                    {!! Form::hidden('timeline_id', $timeline->id) !!}
                                    {!! Form::hidden('timeline_comment_id', 0, ['id' => 'parent-id']) !!}

                                    <div class="input-group">
                                        <input type="text" name="content" class="form-control input-content"
                                               placeholder="">
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
                                    <ul class="media-list mb-2">
                                        @foreach ($comments as $index => $comment)
                                            <li class="media mb-3">
                                                <a href="{{ url('/user/profile/' . $comment->author->id) }}"><img
                                                            class="media-object d-flex align-self-start mr-3"
                                                            src="{{ $comment->author->avatar }}"></a>
                                                <div class="media-body">
                                                    <div>
                                                        <small class="float-right text-muted">
                                                            <a style="margin-left: 10px;"
                                                               id="comment-{{ $comment->id }}"
                                                               onclick="replyOne('{{{$comment->author->nickname}}}', '{{{$comment->id}}}');"
                                                               href="javascript:void(0)">
                                                                <i class="fa fa-reply"></i>
                                                            </a>
                                                        </small>
                                                        <small class="float-right text-muted">{{ $comment->created_at->format('h-d H:i') }}</small>
                                                        <strong><a href="{{ url('/user/profile/' . $comment->author->id) }}">{{ $comment->author->nickname }}</a>
                                                        </strong>
                                                    </div>
                                                    {{ $comment->content }}
                                                </div>
                                            </li>
                                        @endforeach
                                        {!! $comments->render() !!}
                                    </ul>
                                @endif
                            </div>
                        </div>
                    </li>
                </ul>
            </div>

            <!-- LG 3 -->
            <div class="col-lg-3 hidden-xs-down">
                @include('common.userAvatarCard', ['user' => $timeline->author])
                @include('common.userInfoCard', ['user' => $timeline->author])
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
