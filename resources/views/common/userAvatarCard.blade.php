<div class="card card-profile mb-4">
    <div class="card-header" style="background-image: url({{ asset('assets/img/iceland.jpg') }});"></div>
    <div class="card-block text-center">
        <a href="{{ url('/user/profile/' . $user->id) }}">
            <img class="card-profile-img" style="background-color:#eee;" src="{{ $user->avatar }}">
        </a>

        <h6 class="card-title">
            <a class="text-inherit" href="profile/index.html">{{ $user->nickname }}</a>
        </h6>

        <p class="mb-4" style="margin-top:6px; margin-bottom:0 !important;">{{ $user->bio }}</p>

        {{--
            <ul class="card-menu">
                <li class="card-menu-item">
                    <a href="#userModal" class="text-inherit" data-toggle="modal">
                        @lang('hc.friends')
                        <h6 class="my-0">0</h6>
                    </a>
                </li>

                <li class="card-menu-item">
                    <a href="#userModal" class="text-inherit" data-toggle="modal">
                        @lang('hc.level')
                        <h6 class="my-0">1</h6>
                    </a>
                </li>
            </ul>
        --}}
    </div>
</div>
