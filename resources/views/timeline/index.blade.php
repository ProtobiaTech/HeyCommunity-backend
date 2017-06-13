@extends('layouts.home')

@section('content')
    <div class="container pt-4">
        <div class="row">
            <!-- LG 3 -->
            <div class="col-lg-3 hidden-xs-down">
                @include('common.userAvatarCard')

                <div class="card card-tags visible-md-block visible-lg-block mb-4">
                    <div class="card-block">
                        <h6 class="mb-3">@lang('hc.we are talking about')</h6>
                        <div class="tags">
                            @if($keywords->count())
                                @foreach($keywords as $keyword)
                                    <a href="/timeline?keyword={{ $keyword->name }}" class="l1">{{ $keyword->name }}</a>
                                @endforeach
                            @else
                                <span class="muted">@lang('hc.no content yet')</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- LG 6 -->
            <div class="col-lg-6">
                <ul class="list-group media-list media-list-stream mb-4">
                    <li class=" media list-group-item p-4">
                        <form action="{{ url('/timeline/store') }}" method="POST" style="width:100%;">
                            <div class="input-group">
                                <div class="input-group-btn">
                                    <button disabled type="button" class="btn btn-secondary">
                                        <span class="icon icon-images"></span>
                                    </button>
                                </div>
                                <div class="input-group-btn">
                                    <button disabled type="button" class="btn btn-secondary">
                                        <span class="icon icon-video"></span>
                                    </button>
                                </div>
                                <input type="text" name="content" class="form-control"
                                       placeholder="@lang('hc.What\'s news')">
                                <div class="input-group-btn">
                                    <button type="submit" class="btn btn-secondary">
                                        <span class="icon icon-paper-plane"></span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </li>

                    @if($timelines->count())
                        @foreach ($timelines as $timeline)
                            @include('common.timeline')
                        @endforeach
                        {!! $timelines->render() !!}
                    @else
                        @include('common.nodata')
                    @endif
                </ul>
            </div>


            <!-- LG 3 -->
            <div class="col-lg-3">
                <div class="card mb-4 hidden-md-down">
                    <div class="card-block">
                        <h6 class="mb-3">@lang('hc.active user')</h6>
                        <ul class="media-list media-list-stream">
                            @foreach ($users as $user)
                                <li class="media mb-3">
                                    <a class="media-left" href="{{ url('/user/profile/' . $user->id) }}">
                                        <img class="media-object d-flex align-self-start mr-3"
                                             src="{{ $user->avatar }}">
                                    </a>
                                    <div class="media-body" style="margin-top: 8px">
                                        <a class="media-left" href="{{ url('/user/profile/' . $user->id) }}">
                                            <strong>{{ $user->nickname }}</strong>
                                        </a>
                                        <br>
                                        <span class="text-muted" style="font-size:12px;">{{ $user->bio ? $user->bio : trans('hc.no bio') }}</span>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="card-footer">
                        @lang('hc.recommended_follow_text')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
