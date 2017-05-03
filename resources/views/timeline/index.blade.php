@extends('layouts.home')

@section('content')
<div class="container pt-4">
  <div class="row">
    <!-- LG 3 -->
    <div class="col-lg-3 hidden-xs-down">
      @include('common._welcome_login_left')

      @include('common._about_left')

      @include('common._photos_left')

    </div>


    <!-- LG 6 -->
    <div class="col-lg-6">
      <ul class="list-group media-list media-list-stream mb-4">
        <!--
        <li class=" media list-group-item p-4">
          <div class="input-group">
            <input type="text" class="form-control" placeholder="Message">
            <div class="input-group-btn">
              <button type="button" class="btn btn-secondary">
                <span class="icon icon-camera"></span>
              </button>
            </div>
          </div>
        </li>
        -->

        @foreach ($timelines as $timeline)
        <li class="media list-group-item p-4">
          <img class="media-object d-flex align-self-start mr-3" src="{{ $timeline->author->avatar }}">
          <div class="media-body">
            <div class="media-body-text">
              <div class="media-heading">
                <small class="float-right text-muted">{{ $timeline->created_at->format('h-d H:i:m') }}</small>
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

              @if ($timeline->comments)
                <ul class="media-list mb-2">
                  @foreach ($timeline->comments as $index => $comment)
                    <?php if ($index === 3) break; ?>
                    <li class="media mb-3">
                      <img class="media-object d-flex align-self-start mr-3" src="{{ $comment->author->avatar }}">
                      <div class="media-body">
                        <strong>{{ $comment->author->nickname }}: </strong>
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
      <div class="alert alert-warning alert-dismissible hidden-md-down" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <a class="alert-link" href="profile/index.html">@lang('hey_web_info.profile_first')</a> @lang('hey_web_info.profile_end')
      </div>

      <div class="card mb-4 hidden-md-down">
        <div class="card-block">
          <h6 class="mb-3">@lang('hey_web_info.sponsored')</h6>
          <div data-grid="images" data-target-height="150">
            <img class="media-object" data-width="640" data-height="640" data-action="zoom" src="bootstrap-assets/img/instagram_2.jpg">
          </div>
          <p><strong>It might be time to visit Iceland.</strong> Iceland is so chill, and everything looks cool here. Also, we heard the people are pretty nice. What are you waiting for?</p>
          <button class="btn btn-outline-primary btn-sm">@lang('hey_web_info.buy_ticket')</button>
        </div>
      </div>

      <div class="card mb-4 hidden-md-down">
        <div class="card-block">
        <h6 class="mb-3">@lang('hey_web_info.likes') <small>· <a href="#">@lang('hey_web_info.view_all')</a></small></h6>
        <ul class="media-list media-list-stream">
          <li class="media mb-2">
            <img
              class="media-object d-flex align-self-start mr-3"
              src="bootstrap-assets/img/avatar-fat.jpg">
            <div class="media-body">
              <strong>Jacob Thornton</strong> @fat
              <div class="media-body-actions">
                <button class="btn btn-outline-primary btn-sm">
                  <span class="icon icon-add-user"></span> Follow</button>
              </div>
            </div>
          </li>
           <li class="media">
            <a class="media-left" href="#">
              <img
                class="media-object d-flex align-self-start mr-3"
                src="bootstrap-assets/img/avatar-mdo.png">
            </a>
            <div class="media-body">
              <strong>Mark Otto</strong> @mdo
              <div class="media-body-actions">
                <button class="btn btn-outline-primary btn-sm">
                  <span class="icon icon-add-user"></span> @lang('hey_web_info.follow')</button></button>
              </div>
            </div>
          </li>
        </ul>
        </div>
        <div class="card-footer">
          Dave really likes these nerds, no one knows why though.
        </div>
      </div>

      <div class="card card-link-list">
        <div class="card-block">
          © 2015 - 2017 HeyCommunity <br>
          <a href="#">@lang('hey_web_info.about')</a>
          <a href="#">@lang('hey_web_info.help')</a>
          <a href="#">@lang('hey_web_info.terms')</a>
          <a href="#">@lang('hey_web_info.privacy')</a>
          <a href="#">@lang('hey_web_info.cookies')</a>
          <a href="#">@lang('hey_web_info.ads') </a>
          <a href="#">@lang('hey_web_info.info')</a>
          <a href="#">@lang('hey_web_info.brand')</a>
          <a href="#">@lang('hey_web_info.blog')</a>
          <a href="#">@lang('hey_web_info.status')</a>
          <a href="#">@lang('hey_web_info.apps')</a>
          <a href="#">@lang('hey_web_info.jobs')</a>
          <a href="#">@lang('hey_web_info.advertise')</a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
