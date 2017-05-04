@extends('layouts.home')

@section('content')
<div id="hc-activity" class="page-activity container pt-4">
  <div class="row">
    <!-- LG 3 -->
    <div class="col-lg-3 hidden-xs-down">
      @include('common._welcome_login_left')

      @include('common._about_left')

      @include('common._photos_left')

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
