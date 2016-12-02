@extends('layouts.admin')

@section('content')

<link rel="stylesheet" href="{{ asset('bower-assets/editor.md/css/editormd.min.css') }}">
<script src="{{ asset('bower-assets/editor.md/editormd.min.js') }}"></script>
<div class="container">
    <div class="row">
        <div class="col-sm-2">
            @include('admin.official-blog._sidenav')
        </div>

        <div class="col-sm-10">
            <div id="section-breadcrumb">
                <ol class="breadcrumb">
                    <li><a href="{{ url('/admin') }}">HeyCommunity</a></li>
                    <li><a href="{{ url('/admin/blog') }}">{{ trans('dashboard.Blog') }}</a></li>
                    <li class="active">{{ trans('dashboard.Create') }}</li>
                </ol>
            </div>

            <div id="section-mainbody">
                {!! Form::open(array('url' => '/admin/blog', 'method' => 'post', 'class' => 'form form-blog form-horizontal')) !!}
                    <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                        <label for="input-title" class="col-sm-2 control-label">{{ trans('dashboard.Title') }}</label>
                        <div class="col-sm-10">
                            <input type="string" name="title" class="form-control" id="input-title" placeholder="" value="{{ old('title') }}">
                            @if ($errors->has('title'))
                            <div class="help-block">{{ $errors->first('title') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('md_content') ? 'has-error' : '' }}">
                        <label for="input-md-content" class="col-sm-2 control-label">{{ trans('dashboard.Content') }}</label>
                        <div class="col-sm-10">
                            <div id="editormd">
                                <textarea name="md_content" class="form-control" id="input-md-content" placeholder="" rows="9">{{ old('md_content') }}</textarea>
                            </div>
                            @if ($errors->has('md_content'))
                            <div class="help-block">{{ $errors->first('md_content') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-block btn-default">{{ trans('dashboard.Save') }}</button>
                        </div>
                    </div>
                {!! Form::close() !!}

                <script type="text/javascript">
                    $(function() {
                        var editor = editormd("editormd", {
                            height: 500,
                            path: "/bower-assets/editor.md/lib/",
                            saveHTMLToTextarea: true,
                        });
                    });
                </script>
            </div>
        </div>
    </div>
</div>
@endsection

