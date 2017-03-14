@extends('layouts.home')

@section('content')
<div class="container pt-4">
  <div class="row">
    <!-- LG 3 -->
    <div class="col-lg-3 hidden-xs-down">
      <div class="card card-profile mb-4">
        @if (Auth::user()->check())
          <div class="card-header" style="background-image: url(bootstrap-assets/img/iceland.jpg);"></div>
          <div class="card-block text-center">
            <a href="profile/index.html">
              <img class="card-profile-img" style="background-color:#eee;" src="{{ Auth::user()->user()->avatar }}">
            </a>

            <h6 class="card-title">
              <a class="text-inherit" href="profile/index.html">{{ Auth::user()->user()->nickname }}</a>
            </h6>

            <p class="mb-4">{{ Auth::user()->user()->bio }}</p>

            <ul class="card-menu">
              <li class="card-menu-item">
                <a href="#userModal" class="text-inherit" data-toggle="modal">
                  Friends
                  <h6 class="my-0">0</h6>
                </a>
              </li>

              <li class="card-menu-item">
                <a href="#userModal" class="text-inherit" data-toggle="modal">
                  Level
                  <h6 class="my-0">1</h6>
                </a>
              </li>
            </ul>
          </div>
        @else
          <div class="card-header" style="background-image: url(bootstrap-assets/img/iceland.jpg);"></div>
          <div class="card-block text-center">
            <a href="{{ url('/auth/login') }}">
              <img class="card-profile-img" style="background-color:#eee;" src="{{ url('/assets/images/userAvatar-default.png') }}">
            </a>

            <h6 class="card-title">
              <a class="text-inherit" href="{{ url('/auth/login') }}">Please Log In</a>
            </h6>

            <p class="mb-4">Welcome to HeyCommunity, please <a href="{{ url('/auth/login') }}">LogIn</a> to share your life with us</p>
          </div>
        @endif
      </div>

      <div class="card visible-md-block visible-lg-block mb-4">
        <div class="card-block">
          <h6 class="mb-3">About <small>· <a href="#">Edit</a></small></h6>
          <ul class="list-unstyled list-spaced">
            <li><span class="text-muted icon icon-calendar mr-3"></span>Went to <a href="#">Oh, Canada</a>
            <li><span class="text-muted icon icon-users mr-3"></span>Became friends with <a href="#">Obama</a>
            <li><span class="text-muted icon icon-github mr-3"></span>Worked at <a href="#">Github</a>
            <li><span class="text-muted icon icon-home mr-3"></span>Lives in <a href="#">San Francisco, CA</a>
            <li><span class="text-muted icon icon-location-pin mr-3"></span>From <a href="#">Seattle, WA</a>
          </ul>
        </div>
      </div>

       <div class="card visible-md-block visible-lg-block">
        <div class="card-block">
          <h6 class="mb-3">Photos <small>· <a href="#">Edit</a></small></h6>
          <div data-grid="images" data-target-height="150">
            <div>
              <img data-width="640" data-height="640" data-action="zoom" src="bootstrap-assets/img/instagram_5.jpg">
            </div>

            <div>
              <img data-width="640" data-height="640" data-action="zoom" src="bootstrap-assets/img/instagram_6.jpg">
            </div>

            <div>
              <img data-width="640" data-height="640" data-action="zoom" src="bootstrap-assets/img/instagram_7.jpg">
            </div>

            <div>
              <img data-width="640" data-height="640" data-action="zoom" src="bootstrap-assets/img/instagram_8.jpg">
            </div>

            <div>
              <img data-width="640" data-height="640" data-action="zoom" src="bootstrap-assets/img/instagram_9.jpg">
            </div>

            <div>
              <img data-width="640" data-height="640" data-action="zoom" src="bootstrap-assets/img/instagram_10.jpg">
            </div>
          </div>
        </div>
      </div>
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
        <a class="alert-link" href="profile/index.html">Visit your profile!</a> Check your self, you aren't looking well.
      </div>

      <div class="card mb-4 hidden-md-down">
        <div class="card-block">
          <h6 class="mb-3">Sponsored</h6>
          <div data-grid="images" data-target-height="150">
            <img class="media-object" data-width="640" data-height="640" data-action="zoom" src="bootstrap-assets/img/instagram_2.jpg">
          </div>
          <p><strong>It might be time to visit Iceland.</strong> Iceland is so chill, and everything looks cool here. Also, we heard the people are pretty nice. What are you waiting for?</p>
          <button class="btn btn-outline-primary btn-sm">Buy a ticket</button>
        </div>
      </div>

      <div class="card mb-4 hidden-md-down">
        <div class="card-block">
        <h6 class="mb-3">Likes <small>· <a href="#">View All</a></small></h6>
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
                  <span class="icon icon-add-user"></span> Follow</button></button>
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
          <a href="#">About</a>
          <a href="#">Help</a>
          <a href="#">Terms</a>
          <a href="#">Privacy</a>
          <a href="#">Cookies</a>
          <a href="#">Ads </a>
          <a href="#">Info</a>
          <a href="#">Brand</a>
          <a href="#">Blog</a>
          <a href="#">Status</a>
          <a href="#">Apps</a>
          <a href="#">Jobs</a>
          <a href="#">Advertise</a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
