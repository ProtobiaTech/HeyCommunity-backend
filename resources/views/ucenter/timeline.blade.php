@extends('layouts.home')

@section('content')
<div class="container pt-4">
    <div class="row">
        <!-- LG 3 -->
        <div class="col-lg-3">
            @include('ucenter._sidebar', ['user' => Auth::user()->user()])
        </div>

        <!-- LG 9 -->
        <div class="col-lg-9">
            @include('ucenter._tabsNav')

            <div class="pt-4">
                <!-- Timeline -->
                <ul class="list-group media-list media-list-stream mb-4">
                    <?php $timelines = \App\Timeline::get(); ?>

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

                          {{--
                          <div class="mb-2 text-right">
                            <!-- <a class="btn btn-default btn-xs"><i class="fa fa-heart" style="color:red;"></i></a> -->
                            <a style="font-size:1rem;" class="btn btn-default btn-xs" href="#"><i class="fa fa-comment" style="color:#333"></i></a>
                          </div>
                          --}}

                          <div class="mb-2" style="margin-bottom:1rem !important;">
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

                          @if ($timeline->comments)
                            <ul class="media-list mb-2">
                              @foreach ($timeline->comments as $index => $comment)
                                <?php if ($index === 3) break; ?>
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
        </div>
    </div>
</div>
@endsection
