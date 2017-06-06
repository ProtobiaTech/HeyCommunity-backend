<li class="list-group-item">
    <a href="{{ url('/user/profile/' . $notice->initiator->id) }}" style="margin-right: 8px"><strong>{{ $notice->initiator->nickname }}</strong></a>
    <?php Carbon\Carbon::setLocale('zh'); ?>
    @if($notice->entity_type == "App\\TimelineLike")
        @lang('notice.Like Your Timeline')
        <div style="position:absolute; right:1rem; top:0.75rem;">
            <small>
                <a class="" href="{{ url('/timeline/show/' . $notice->target_id) }}">@lang('hc.detail')</a>
                &nbsp;&nbsp;
                <span class="">{{ $notice->created_at->diffForHumans() }}</span>
            </small>
        </div>
    @elseif($notice->entity_type == "App\\TimelineComment" && $notice->target_type == "App\\TimelineComment")
        @lang('notice.Reply Your TimelineComment: ') <small>{{ $notice->entity->content }}</small>
        <div style="position:absolute; right:1rem; top:0.75rem;">
            <small>
                <a class="" href="{{ url('/timeline/show/' . $notice->entity->timeline_id) }}">@lang('hc.detail')</a>
                &nbsp;&nbsp;
                <span class="">{{ $notice->created_at->diffForHumans() }}</span>
            </small>
        </div>
    @elseif($notice->entity_type == "App\\TimelineComment" && $notice->target_type == "App\\Timeline")
        @lang('notice.Comment Your Timeline: ') <small>{{ $notice->entity->content }}</small>
        <div style="position:absolute; right:1rem; top:0.75rem;">
            <small>
                <a class="" href="{{ url('/timeline/show/' . $notice->target_id) }}">@lang('hc.detail')</a>
                &nbsp;&nbsp;
                <span class="">{{ $notice->created_at->diffForHumans() }}</span>
            </small>
        </div>
    @elseif($notice->entity_type == "App\\TopicComment" && $notice->target_type == "App\\TopicComment")
        @lang('notice.Reply Your TopicComment: ') <small>{{ $notice->entity->content }}</small>
        <div style="position:absolute; right:1rem; top:0.75rem;">
            <small>
                <a class="" href="{{ url('/topic/show/' . $notice->entity->topic_id) }}">@lang('hc.detail')</a>
                &nbsp;&nbsp;
                <span class="">{{ $notice->created_at->diffForHumans() }}</span>
            </small>
        </div>
    @elseif($notice->entity_type == "App\\TopicComment" && $notice->target_type == "App\\Topic")
        @lang('notice.Comment Your Topic: ') <small>{{ $notice->entity->content }}</small>
        <div style="position:absolute; right:1rem; top:0.75rem;">
            <small>
                <a class="" href="{{ url('/timeline/topic/' . $notice->target_id) }}">@lang('hc.detail')</a>
                &nbsp;&nbsp;
                <span class="">{{ $notice->created_at->diffForHumans() }}</span>
            </small>
        </div>
    @endif
</li>