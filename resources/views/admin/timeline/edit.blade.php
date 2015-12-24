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
                <li class="active">Edit</li>
            </ol>

            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {!! Form::open(array('route' => ['admin.timeline.update', $timeline->id], 'method' => 'PATCH', 'class' => 'form form-horizontal', 'enctype' => 'multipart/form-data')) !!}
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="title">Title</label>
                    <div class="col-sm-6">
                        <input class="form-control" type="text" name="title" value="{{ old('title', $timeline->title) }}" placeholder="">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label" for="content">Content</label>
                    <div class="col-sm-6">
                        <textarea class="form-control" name="content" placeholder="">{{ old('content', $timeline->content) }}</textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label" for="attachment">Attachment</label>
                    <div class="col-sm-6">
                        <input class="form-control" type="file" name="attachment">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-6 col-sm-offset-2">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection

