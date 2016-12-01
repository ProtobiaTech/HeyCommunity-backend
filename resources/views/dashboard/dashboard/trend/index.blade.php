@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-2">
            <ul class="nav nav-pills nav-stacked" role="tablist">
                <li class="active"><a>Preview</a></li>
            </ul>
        </div>

        <div class="col-sm-9 text-center">
            <h2>Trend Preview</h2>

            <div id="all-trend"></div>





            {!! $lava->render('LineChart', 'AllTrend', 'all-trend') !!}
        </div>
    </div>
</div>
@endsection

