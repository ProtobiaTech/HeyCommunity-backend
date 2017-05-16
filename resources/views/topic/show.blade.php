@extends('layouts.home')

@section('content')
<div id="hc-topic" class="container page-topic-show pt-4">
  <div class="row">
    <!-- LG 3 -->
    <div class="col-lg-3 hidden-xs-down" style="margin-top: 15px">
      <div class="card card-profile mb-4">
        <div class="card-header" style="background-image: url({{ asset('bootstrap-assets/img/iceland.jpg') }});"></div>
        <div class="card-block text-center">
            <span>
                <img class="card-profile-img" style="background-color:#eee;" src="{{ $topic->author->avatar }}">
            </span>

            <h6 class="card-title">
                <span>{{ $topic->author->nickname }}</span>
            </h6>
        </div>
      </div>
    </div>


    <!-- LG 9 -->
    <div class="col-lg-9">
      <div class="row page-title-row">
        <div class="col-md-12" style="margin-top: 15px">
          <h3>{{ $topic->title }}</h3>
          <p class="content">{!! $topic->content !!}</p>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
