<li class="media list-group-item p-4">
    <a class="media-object d-flex align-self-start mr-3" href="{{ url('/user/profile/' . $timeline->author->id) }}">
        <img class="media-object d-flex align-self-start mr-3" src="{{ $timeline->author->avatar }}">
    </a>
    <div class="media-body">
        <div class="media-body-text">
            <div class="media-heading">
                <small class="float-right text-muted">{{ $timeline->created_at->format('h-d H:i:m') }}</small>
                <small class="float-right text-muted">
                    <i class="fa fa-fire"></i> <span>{{ $timeline->like_num + $timeline->comment_num * 2 }}</span>
                    &nbsp;&nbsp;
                </small>
                <a href="{{ url('/user/profile/' . $timeline->author->id) }}">
                    <h6>{{ $timeline->author->nickname }}</h6>
                </a>
            </div>

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

            <div class="mb-2">
                <div class="text-muted pull-left">
                    <a class="btn btn-link btn-xs" href="{{ url('/timeline/show/' . $timeline->id) }}">
                        <i class="fa fa-newspaper-o"></i>
                    </a>
                </div>

                <div class="pull-right">

                    <a class="btn btn-link btn-xs"
                       onclick="event.preventDefault();
                               document.getElementById('timeline-like-form-{{$timeline->id}}').submit();">
                        <i class="fa fa-heart{{ $timeline->isLike ? '' : '-o' }}"
                           style="{{ $timeline->isLike ? 'color:red;' : 'color:#333;' }}"></i>
                        <div style="display: none">
                            {!! Form::open(array('url' => '/timeline/set-like', 'method' => 'POST', 'id' => 'timeline-like-form-' . $timeline->id)) !!}
                            {{ csrf_field() }}
                            {!! Form::hidden('id', $timeline->id) !!}
                            {!! Form::close() !!}
                        </div>
                    </a>

                    <a style="font-size:1rem;" class="btn btn-link btn-xs"
                       href="javascript:$('.form-timeline-comment-{{ $timeline->id }}').toggle()">
                        <i class="fa fa-comment" style="color:#333"></i>
                    </a>
                </div>

                <div class="clearfix"></div>

            </div>

            <div class="mb-2 form-timeline-comment-{{ $timeline->id }}"
                 style="display:none; margin-bottom:1rem !important;">
                {!! Form::open(array('url' => '/timeline/store-comment', 'method' => 'POST')) !!}
                {{ csrf_field() }}
                {!! Form::hidden('timeline_id', $timeline->id) !!}
                <div class="input-group">
                    <input type="text" name="content" class="form-control" placeholder="">
                    <div class="input-group-btn">
                        <button type="submit" class="btn btn-secondary">
                            <span class="icon icon-paper-plane"></span>
                        </button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
            <hr style="margin-top:0;">

            @if ($timeline->comments)
                <ul class="media-list mb-2">
                    @foreach ($timeline->comments as $index => $comment)
                        <?php if (false && $index === 3) break; ?>
                        <li class="media mb-3">
                            <a href="{{ url('/user/profile/' . $comment->author->id) }}"><img
                                        class="media-object d-flex align-self-start mr-3"
                                        src="{{ $comment->author->avatar }}"></a>
                            <div class="media-body">
                                <div>
                                    <small class="float-right text-muted">{{ $comment->created_at->format('h-d H:i') }}</small>
                                    <strong><a href="{{ url('/user/profile/' . $comment->author->id) }}">{{ $comment->author->nickname }}</a>
                                    </strong>
                                </div>
                                {{ $comment->content }}
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</li>