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
                        <th>Author</th>
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
                        <td style="white-space:nowrap;">{{ $item->author->nickname }}</td>
                        <td><img style="height:60px;" src="{{ $item->attachment }}"></td>
                        <td>{{ $item->title }}</td>
                        <td>{{ $item->content }}</td>
                        <td style="white-space:nowrap;">
                            <a class="btn btn-sm btn-default" href="{{ route('admin.timeline.edit', $item->id) }}"><i class="fa fa-edit"></i></a>
                            {!! Form::open(['method' => 'DELETE', 'route' => ['admin.timeline.destroy', $item->id], 'onsubmit' => 'return myConfirmDelete()', 'style' => 'display:inline-block']) !!}
                                {!! Form::button('<i class="fa fa-trash"></i>', array('type' => 'submit', 'class' => 'btn btn-sm btn-danger')) !!}
                            {!! Form::close() !!}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {!! $timeline->render() !!}
        </div>
    </div>
</div>
@endsection

