@extends('layouts.home')

@section('content')
    <div id="hc-topic" class="page-topic container pt-4">
        <div class="row">
            <!-- LG 3 -->
            <div class="col-lg-3 hidden-xs-down">
                <div class="card-tools">
                    <a class="btn btn-primary btn-block" href="{{url('topic/create')}}">@lang('hc.create topic')</a>
                </div>

                <div class="card card-nodes visible-md-block visible-lg-block mb-4">
                    <div class="card-block">
                        <h6 class="mb-3">@lang('节点列表')</h6>
                        <div class="">
                            @foreach ($topicNodes as $node)
                                <div class="nodes-item">
                                    <span>{{ $node->name }}</span>
                                    @foreach ($node->children as $childNode)
                                        <a href="/topic?node={{ $childNode->name }}">{{ $childNode->name }}</a>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>


                <div class="card card-tags visible-md-block visible-lg-block mb-4">
                    <div class="card-block">
                        <h6 class="mb-3">@lang('hc.we are discussing')</h6>
                        <div class="tags">
                            @if($keywords->count())
                                @foreach($keywords as $keyword)
                                    <a href="/topic?keyword={{ $keyword->name }}" class="l1">{{ $keyword->name }}</a>
                                @endforeach
                            @else
                                <span class="muted">@lang('hc.no content yet')</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>


            <!-- LG 9 -->
            <div class="col-lg-9">
                <div class="card-tools">
                    <a class="btn btn-secondary {{ Request::input('filter') == 'recent' ? 'active' : '' }}"
                       href="/topic?filter=recent">@lang('最近')</a>
                    <a class="btn btn-secondary {{ Request::input('filter') == 'hot' ? 'active' : '' }}"
                       href="/topic?filter=hot">@lang('最热')</a>
                    <a class="btn btn-secondary {{ Request::input('filter') == 'excellent' ? 'active' : '' }}"
                       href="/topic?filter=excellent">@lang('精华')</a>
                    &nbsp;&nbsp;
                    <a class="btn btn-secondary {{ Request::input('filter') == 'noreply' ? 'active' : '' }}"
                       href="/topic?filter=noreply">@lang('零回复')</a>

                    <div class="pull-right">
                        <a class="btn btn-secondary" href="/topic?filter=default">刷新</a>
                    </div>
                </div>

                <div class="list-group list-topic">
                    @if($topics->count())
                        @foreach ($topics as $topic)
                            @include('common.topic')
                        @endforeach
                    @else
                        @include('common.nodata')
                    @endif
                </div>
                <br>
                <div>
                    @include('common.pagination', ['paginator' => $topics])
                </div>
            </div>
        </div>
    </div>
@endsection
