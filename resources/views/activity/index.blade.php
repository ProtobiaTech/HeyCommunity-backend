@extends('layouts.home')

@section('content')
<div id="hc-activity" class="page-activity container pt-4">
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


    <!-- LG 9 -->
    <div class="col-lg-9">
      <div class="list-group list-activity">
        <div class="row">
          @foreach ($timelines as $timeline)
            <div class="col-lg-12">
              <div class="card card-activity">
                <?php
                    $timelineImgs = $timeline->getImgs();
                    $img = null;
                    if ($timelineImgs) {
                      $img = $timelineImgs[0]->uri;
                    }
                ?>
                @if ($img)
                  <div class="img-box">
                    <img class="card-img-top" src="{{ $img }}" alt="Card image cap">
                  </div>
                @endif
                <div class="card-block">
                  <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
