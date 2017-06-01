<div class="card visible-md-block visible-lg-block mb-4">
    <div class="card-block">
        <h6 class="mb-3">@lang('hc.about')</h6>
        <ul class="list-unstyled list-spaced">
            <li><span class="text-muted icon icon-email" style="margin-right: 5px;"></span>{{ $user->email }}</li>
            <li><span class="text-muted icon icon-user" style="margin-right: 5px;"></span>{{ \App\User::getGenderName($user->gender) }}</li>
            <li><span class="text-muted icon icon-home" style="margin-right: 5px;"></span>@lang('hc.lives in')<a href="#">San Francisco, CA</a></li>
            <li><span class="text-muted icon icon-location-pin" style="margin-right: 5px;"></span>@lang('hc.from')<a href="#">Seattle, WA</a></li>
        </ul>
    </div>
</div>
