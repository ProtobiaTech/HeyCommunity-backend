@extends('layouts.home')

@section('content')
    <div id="hc-topic" class="page-topic container pt-4 search-results">
        <div class="row">
            <!-- LG 12 -->
            <div class="col-lg-12 hidden-xs-down">
                <div class="card-tools">
                    <i class="fa fa-search"></i> "{{ $query }}
                    "的搜索结果共 {{ $topics->total() + $timelines->total() + count($users) }} 条
                </div>

            </div>


            <!-- LG 6-->
            <div class="col-lg-6">
                <h4>@lang('hc.timeline')</h4>
                <ul class="list-group media-list media-list-stream mb-4">
                    @if($timelines->count())
                        @foreach ($timelines as $timeline)
                            <li class="media list-group-item p-4">
                                <a class="media-object d-flex align-self-start mr-3"
                                   href="{{ url('/user/profile/' . $timeline->author->id) }}">
                                    <img class="media-object d-flex align-self-start mr-3"
                                         src="{{ $timeline->author->avatar }}">
                                </a>
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
                                                <h6>{{ $timeline->author->nickname }}</h6>
                                            </a>
                                        </div>

                                        <p>{{ str_limit($timeline->content, 200) }}</p>
                                    </div>
                                </div>
                            </li>
                        @endforeach

                        {!! $timelines->appends(['query' => $query])->render() !!}
                    @else
                        @include('common.nodata')
                    @endif
                </ul>
            </div>


            <!-- LG 6-->
            <div class="col-lg-6">
                <h4>@lang('hc.topic')</h4>
                <div class="list-group list-topic">
                    @if($topics->count())
                        @foreach ($topics as $topic)
                            @include('common.topic')
                        @endforeach

                        {!! $topics->appends(['query' => $query])->render() !!}
                    @else
                        @include('common.nodata')
                    @endif
                </div>
            </div>

            <!-- LG 12 -->
            <div class="col-lg-12 hidden-xs-down">
                <h4>@lang('dashboard.User')</h4>
                @if($users->count())
                    @foreach ($users as $user)
                        <div class="modal-content">
                            <div class="modal-body p-a-0 js-modalBody">
                                <div class="modal-body-scroller">
                                    <div class="media-list media-list-users list-group js-msgGroup">
                                        <a href="#" class="list-group-item">
                                            <div class="media">
                                                    <span class="media-left">
                                                    <img class="img-circle media-object" src="{{ $user->avatar }}">
                                                    </span>
                                                <div class="media-body">
                                                    <strong>{{ $user->nickname }}</strong>
                                                    <div class="media-body-secondary">
                                                        {{ $user->bio }}
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    @include('common.nodata')
                @endif

            </div>
        </div>
    </div>
@endsection

@section('script')
    //TODO: 高亮功能
@endsection
