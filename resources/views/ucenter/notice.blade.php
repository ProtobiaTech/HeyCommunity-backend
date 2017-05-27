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
                <!-- Notices -->
                <ul class="list-group">
                    <li class="list-group-item">
                        <strong>Rod</strong>: Cras justo odio

                        <div style="position:absolute; right:1rem; top:0.75rem;">
                            <small>
                                <a class="" href="">Detail</a>
                                &nbsp;&nbsp;
                                <span class="">06-28 12:12:12</span>
                            </small>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <strong>Rod</strong>: Cras justo odio

                        <div style="position:absolute; right:1rem; top:0.75rem;">
                            <small>
                                <a class="" href="">Detail</a>
                                &nbsp;&nbsp;
                                <span class="">06-28 12:12:12</span>
                            </small>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <strong>Rod</strong>: Cras justo odio

                        <div style="position:absolute; right:1rem; top:0.75rem;">
                            <small>
                                <a class="" href="">Detail</a>
                                &nbsp;&nbsp;
                                <span class="">06-28 12:12:12</span>
                            </small>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
