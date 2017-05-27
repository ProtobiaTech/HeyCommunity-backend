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
                <span class="muted">@lang('hc.no content yet')</span>
                <!--
                <a href="" class="l1">苹果</a>
                <a href="" class="l2">马戏团</a>
                <a href="" class="l2">美国</a>
                <a href="" class="l1">美国</a>
                <a href="" class="l3">美国</a>
                <a href="" class="l1">美国</a>
                <a href="" class="l4">美国</a>
                <a href="" class="l4">美国</a>
                -->
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
              <input type="text" name="content" class="form-control" placeholder="@lang('hc.What\'s news')">
              <div class="input-group-btn">
                <button type="submit" class="btn btn-secondary">
                  <span class="icon icon-paper-plane"></span>
                </button>
              </div>
            </div>
          </form>
        </li>

        @foreach ($timelines as $timeline)
        <li class="media list-group-item p-4">
          <img class="media-object d-flex align-self-start mr-3" src="{{ $timeline->author->avatar }}">
          <div class="media-body">
            <div class="media-body-text">
              <div class="media-heading">
                <small class="float-right text-muted">{{ $timeline->created_at->format('h-d H:i:m') }}</small>
                <small class="float-right text-muted">
                  <i class="fa fa-fire"></i> <span>{{ $timeline->like_num + $timeline->comment_num * 2 }}</span>
                  &nbsp;&nbsp;
                </small>
                <h6>{{ $timeline->author->nickname }}</h6>
              </div>
              <p>{{ $timeline->content }}</p>
              @if ($timeline->images)
                <div class="media-body-inline-grid" data-grid="images">
                  <?php $timelineImgs = $timeline->getImgs(); ?>
                  @foreach ($timelineImgs as $image)
                    <div style="display: none">
                      <img data-action="zoom" data-width="100%"  src="{{ $image->uri }}">
                    </div>
                  @endforeach
                </div>
              @endif

              <div class="mb-2">
                <div class="text-muted pull-left">
                  <a class="btn btn-link btn-xs" href="{{ url('/timeline/show/' . $timeline->id) }}"><i class="fa fa-newspaper-o"></i></a>
                </div>

                <div class="pull-right">
                  @if (true)
                    <a class="btn btn-link btn-xs" href="#"><i class="fa fa-heart-o" style="color:#333;"></i></a>
                  @else
                    <a class="btn btn-link btn-xs" href="#"><i class="fa fa-heart" style="color:red;"></i></a>
                  @endif
                  <a style="font-size:1rem;" class="btn btn-link btn-xs" href="javascript:$('.form-timeline-comment-{{ $timeline->id }}').toggle()"><i class="fa fa-comment" style="color:#333"></i></a>
                </div>

                <div class="clearfix"></div>

              </div>

              <div class="mb-2 form-timeline-comment-{{ $timeline->id }}" style="display:none; margin-bottom:1rem !important;">
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
                      <img class="media-object d-flex align-self-start mr-3" src="{{ $comment->author->avatar }}">
                      <div class="media-body">
                        <div>
                          <small class="float-right text-muted">{{ $comment->created_at->format('h-d H:i') }}</small>
                          <strong>{{ $comment->author->nickname }} </strong>
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
        @endforeach
      </ul>
    </div>


    <!-- LG 3 -->
    <div class="col-lg-3">
      <!--
      <div class="hide alert alert-warning alert-dismissible hidden-md-down" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <a class="alert-link" href="profile/index.html">@lang('hc.profile_first')</a> @lang('hc.profile_end')
      </div>

      <div class="card mb-4 hidden-md-down">
        <div class="card-block">
          <h6 class="mb-3">@lang('hc.sponsored')</h6>
          <div data-grid="images" data-target-height="150">
            <img class="media-object" data-width="640" data-height="640" data-action="zoom" src="bootstrap-assets/img/instagram_2.jpg">
          </div>
          <p><strong>It might be time to visit Iceland.</strong> Iceland is so chill, and everything looks cool here. Also, we heard the people are pretty nice. What are you waiting for?</p>
          <button class="btn btn-outline-primary btn-sm">@lang('hc.buy ticket')</button>
        </div>
      </div>
      -->

      <div class="card mb-4 hidden-md-down">
        <div class="card-block">
        <h6 class="mb-3">@lang('推荐关注')</h6>
        <ul class="media-list media-list-stream">
          @foreach ($users as $user)
            <li class="media mb-2">
              <a class="media-left" href="#">
                <img class="media-object d-flex align-self-start mr-3" src="{{ $user->avatar }}">
              </a>
              <div class="media-body">
                <span>{{ $user->nickname }}</span>
                <div class="media-body-actions">
                  <button class="btn btn-outline-primary btn-sm">
                    <span class="icon icon-add-user"></span> @lang('hc.follow')</button></button>
                </div>
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
