@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-2">
            @include('admin.timeline._side_nav')
        </div>

        <div class="col-sm-10">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Content</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ([1,2,3,4,5,6] as $item)
                    <tr>
                        <td>null</td>
                        <td>null</td>
                        <td>null</td>
                        <td>null</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

