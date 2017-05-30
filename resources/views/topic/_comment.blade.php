<li class="media mb-3">
    <img class="media-object d-flex align-self-start mr-3" src="{{ $comment->author->avatar }}">
    <div class="media-body">
        <div>
            <small class="float-right text-muted">
                <a style="margin-left: 10px;" id="comment-{{ $comment->id }}"
                   onclick="replyOne('{{{$comment->author->nickname}}}', '{{{$comment->id}}}');"
                   href="javascript:void(0)">
                    <i class="fa fa-reply"></i>
                </a>
            </small>
            <small class="float-right text-muted">{{ $comment->created_at->format('h-d H:i') }}</small>
            <strong>{{ $comment->author->nickname }} </strong>
        </div>
        {{ $comment->content }}
    </div>
</li>
