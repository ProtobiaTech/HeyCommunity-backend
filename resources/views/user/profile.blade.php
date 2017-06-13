@extends('layouts.home')

@section('content')
    <div class="container pt-4">
        <div class="row">
            <!-- LG 3 -->
            <div class="col-lg-3">
                @include('ucenter._sidebar', ['user' => $user])
            </div>

            <!-- LG 9 -->
            <div class="col-lg-9">
                @include('user._tabsNav')
            </div>
        </div>
    </div>
@endsection
