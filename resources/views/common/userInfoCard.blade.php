<div class="card visible-md-block visible-lg-block mb-4">
    <div class="card-block">
        <h6 class="mb-3">@lang('hc.about')</h6>
        <ul class="list-unstyled list-spaced">
            <li><span class="text-muted icon icon-email" style="margin-right: 5px;"></span>{{ $user->email }}</li>
            <li><span class="text-muted icon icon-user" style="margin-right: 5px;"></span>{{ \App\User::getGenderName($user->gender) }}</li>
            <li><span class="text-muted icon icon-book" style="margin-right: 5px;"></span>{{ $user->bio }}</li>
        </ul>
    </div>
</div>
