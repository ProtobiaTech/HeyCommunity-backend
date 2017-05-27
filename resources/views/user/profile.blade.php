@extends('layouts.home')

@section('content')
<div class="container pt-4">
    <div class="row">
        <!-- LG 3 -->
        <div class="col-lg-3">
            <div class="card card-profile mb-4">
                <div class="card-header" style="background-image: url({{ asset('bootstrap-assets/img/iceland.jpg') }});"></div>
                <div class="card-block text-center">
                    <span>
                        <img class="card-profile-img" style="background-color:#eee;" src="{{ $user->avatar }}">
                    </span>

                    <h6 class="card-title">
                        <span>{{ $user->nickname }}</span>
                    </h6>
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
