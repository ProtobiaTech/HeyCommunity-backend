@extends('layouts.home')

@section('content')
<div class="container" style="margin-top: 40px;">
    <div class="row">
        <!-- LG 3 -->
        <div class="col-lg-3">
            <div class="profile-header" style="border-radius:1em; background-image: url({{ asset('assets/img/iceland.jpg') }});">
                <div class="container">
                    <div class="container-inner">
                        <img class="rounded-circle media-object" src="{{ asset($user->avatar) }}" style="border-radius:50%; background-color:#ddd;">
                        <h3 class="profile-header-user">{{ $user->nickname }}</h3>
                        <p class="profile-header-bio">
                            {{ $user->bio }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- LG 3 -->
        <div class="col-lg-9">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link active" href="#">Timeline</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Topic</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Participate Of Topic</a>
                </li>
            </ul>
        </div>
    </div>
</div>

@endsection
