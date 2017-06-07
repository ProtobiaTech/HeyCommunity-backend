<li class="list-group-item" style="{{ $notice->is_checked ? "color: lightgray" : "" }}">
    <a href="{{ url('/user/profile/' . $notice->initiator->id) }}" style="margin-right: 8px"><strong>{{ $notice->initiator->nickname }}</strong></a>
    <?php Carbon\Carbon::setLocale('zh'); ?>
    @if($notice->entity_type == "App\\TimelineLike")
        <strong>@lang('notice.Like Your Timeline')</strong>
        <div style="position:absolute; right:1rem; top:0.75rem;">
            <small>
                <a class="" href="{{ url('/timeline/show/' . $notice->target_id) }}" onclick="checkNotice({{ $notice->id }})">@lang('hc.detail')</a>
                &nbsp;&nbsp;
                <span class="">{{ $notice->created_at->diffForHumans() }}</span>
            </small>
        </div>
    @elseif($notice->entity_type == "App\\TimelineComment" && $notice->target_type == "App\\TimelineComment")
        <strong>@lang('notice.Reply Your TimelineComment: ') <u style="margin-left: 8px">{{ $notice->entity->content }}</u></strong>
        <div style="position:absolute; right:1rem; top:0.75rem;">
            <small>
                <a class="" href="{{ url('/timeline/show/' . $notice->entity->timeline_id) }}" onclick="checkNotice({{ $notice->id }})">@lang('hc.detail')</a>
                &nbsp;&nbsp;
                <span class="">{{ $notice->created_at->diffForHumans() }}</span>
            </small>
        </div>
    @elseif($notice->entity_type == "App\\TimelineComment" && $notice->target_type == "App\\Timeline")
        <strong>@lang('notice.Comment Your Timeline: ') <u style="margin-left: 8px">{{ $notice->entity->content }}</u></strong>
        <div style="position:absolute; right:1rem; top:0.75rem;">
            <small>
                <a class="" href="{{ url('/timeline/show/' . $notice->target_id) }}" onclick="checkNotice({{ $notice->id }})">@lang('hc.detail')</a>
                &nbsp;&nbsp;
                <span class="">{{ $notice->created_at->diffForHumans() }}</span>
            </small>
        </div>
    @elseif($notice->entity_type == "App\\TopicComment" && $notice->target_type == "App\\TopicComment")
        <strong>@lang('notice.Reply Your TopicComment: ') <u style="margin-left: 8px">{{ $notice->entity->content }}</u></strong>
        <div style="position:absolute; right:1rem; top:0.75rem;">
            <small>
                <a class="" href="{{ url('/topic/show/' . $notice->entity->topic_id) }}" onclick="checkNotice({{ $notice->id }})">@lang('hc.detail')</a>
                &nbsp;&nbsp;
                <span class="">{{ $notice->created_at->diffForHumans() }}</span>
            </small>
        </div>
    @elseif($notice->entity_type == "App\\TopicComment" && $notice->target_type == "App\\Topic")
        <strong>@lang('notice.Comment Your Topic: ') <u style="margin-left: 8px">{{ $notice->entity->content }}</u></strong>
        <div style="position:absolute; right:1rem; top:0.75rem;">
            <small>
                <a class="" href="{{ url('/topic/show/' . $notice->target_id) }}" onclick="checkNotice({{ $notice->id }})">@lang('hc.detail')</a>
                &nbsp;&nbsp;
                <span class="">{{ $notice->created_at->diffForHumans() }}</span>
            </small>
        </div>
    @endif
</li>