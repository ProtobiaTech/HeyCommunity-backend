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
                    @foreach ($timeline as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
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

