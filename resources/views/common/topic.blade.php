<div class="list-group-item">
    <a class="avatar" href="{{ url('/user/profile/' . $topic->author->id) }}"><img class="avatar"
                                                                                   src="{{ $topic->author->avatar }}"></a>
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