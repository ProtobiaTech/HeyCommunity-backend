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

            <p class="mb-4" style="margin-top:6px; margin-bottom:0 !important;">{{ Auth::user()->user()->bio }}</p>

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
    @else
        <div class="card-header" style="background-image: url(bootstrap-assets/img/iceland.jpg);"></div>
        <div class="card-block text-center">
            <a href="{{ url('/auth/login') }}">
                <img class="card-profile-img" style="background-color:#eee;" src="{{ url('/assets/images/userAvatar-default.png') }}">
            </a>

            <h6 class="card-title">
                <a class="text-inherit" href="{{ url('/auth/login') }}">@lang('hc.please login')</a>
            </h6>

            <p class="mb-4">@lang('hc.welcome_first') <a href="{{ url('/auth/login') }}">@lang('hc.login')</a>@lang('hc.welcome_end')</p>
        </div>
    @endif
</div>
