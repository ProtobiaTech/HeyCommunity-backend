<li class="list-group-item">
    <a href="{{ url('/user/profile/' . $notice->initiator->id) }}"><strong>{{ $notice->initiator->nickname }}</strong></a>

    @if($notice->entity_type == "App\\TimelineLike")
        给你的动态点了赞
        <div style="position:absolute; right:1rem; top:0.75rem;">
            <small>
                <a class="" href="{{ url('/timeline/show/' . $notice->target_id) }}">Detail</a>
                &nbsp;&nbsp;
                <span class="">{{ $notice->created_at->diffForHumans() }}</span>
            </small>
        </div>
    @elseif($notice->entity_type == "App\\TimelineComment" && $notice->target_type == "App\\TimelineComment")
        回复了你的动态评论
        <div style="position:absolute; right:1rem; top:0.75rem;">
            <small>
                <a class="" href="{{ url('/timeline/show/' . $notice->entity->timeline_id) }}">Detail</a>
                &nbsp;&nbsp;
                <span class="">{{ $notice->created_at->diffForHumans() }}</span>
            </small>
        </div>
    @elseif($notice->entity_type == "App\\TimelineComment" && $notice->target_type == "App\\Timeline")
        回复了你的话题
        <div style="position:absolute; right:1rem; top:0.75rem;">
            <small>
                <a class="" href="{{ url('/timeline/show/' . $notice->target_id) }}">Detail</a>
                &nbsp;&nbsp;
                <span class="">{{ $notice->created_at->diffForHumans() }}</span>
            </small>
        </div>
    @elseif($notice->entity_type == "App\\TopicComment" && $notice->target_type == "App\\TopicComment")
        回复了你的话题评论
        <div style="position:absolute; right:1rem; top:0.75rem;">
            <small>
                <a class="" href="{{ url('/topic/show/' . $notice->entity->topic_id) }}">Detail</a>
                &nbsp;&nbsp;
                <span class="">{{ $notice->created_at->diffForHumans() }}</span>
            </small>
        </div>
    @elseif($notice->entity_type == "App\\TopicComment" && $notice->target_type == "App\\Topic")
        回复了你的话题
        <div style="position:absolute; right:1rem; top:0.75rem;">
            <small>
                <a class="" href="{{ url('/timeline/topic/' . $notice->target_id) }}">Detail</a>
                &nbsp;&nbsp;
                <span class="">{{ $notice->created_at->diffForHumans() }}</span>
            </small>
        </div>
    @endif
</li>