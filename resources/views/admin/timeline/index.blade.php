@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-2">
            @include('admin.timeline._side_nav')
        </div>

        <div class="col-sm-10">
            <ol class="breadcrumb">
                <li><a href="{{ route('admin.home') }}">Home</a></li>
                <li><a href="{{ route('admin.timeline.index') }}">Timeline</a></li>
                <li class="active">List</li>
            </ol>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Attachment</th>
                        <th>Title</th>
                        <th>Content</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($timeline as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td><img style="height:60px;" src="{{ $item-> attachment }}"></td>
                        <td>{{ $item->title }}</td>
                        <td>{{ $item->content }}</td>
                        <td></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {!! $timeline->render() !!}
        </div>
    </div>
</div>
@endsection

