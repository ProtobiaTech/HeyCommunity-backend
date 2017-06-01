<div class="card visible-md-block visible-lg-block">
    <div class="card-block">
        <h6 class="mb-3">@lang('hc.photos')</h6>
        @if($user->timelineImages)
            <div data-grid="images" data-target-height="150">
                @foreach($user->timelineImages->take(6) as $image)
                    <div>
                        <img data-width="640" data-height="640" data-action="zoom" src="{{ $image->uri }}">
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
