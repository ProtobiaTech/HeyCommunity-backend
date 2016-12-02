{!! Form::open(array('url' => '/admin/blog', 'method' => 'post', 'class' => 'form form-blog form-horizontal')) !!}
    <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
        <label for="input-title" class="col-sm-2 control-label">{{ trans('dashboard.Title') }}</label>
        <div class="col-sm-10">
            <input type="string" name="title" class="form-control" id="input-title" placeholder="" value="{{ old('title', $blog->title) }}">
            @if ($errors->has('title'))
            <div class="help-block">{{ $errors->first('title') }}</div>
            @endif
        </div>
    </div>

    <div class="form-group {{ $errors->has('md_content') ? 'has-error' : '' }}">
        <label for="input-md-content" class="col-sm-2 control-label">{{ trans('dashboard.Content') }}</label>
        <div class="col-sm-10">
            <div id="editormd">
                <textarea name="md_content" class="form-control" id="input-md-content" placeholder="" rows="9">{{ old('md_content', $blog->md_content) }}</textarea>
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
