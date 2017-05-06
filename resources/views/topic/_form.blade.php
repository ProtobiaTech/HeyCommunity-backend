<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="form-group">
            <label for="title" class="col-md-2 col-sm-3 control-label">
                @lang('hey_web_info.topic_title')
            </label>
            <div class="col-md-12 col-sm-12">
                <input type="text" class="form-control" name="title" autofocus id="title" value="{{ $title }}">
            </div>
        </div>

        <div class="form-group">
            <label for="content" class="col-md-2 col-sm-3 control-label">
                @lang('hey_web_info.topic_content')
            </label>
            <div class="col-md-12 col-sm-12">
                <textarea class="form-control" name="content" rows="14" id="content">{{ $content }}</textarea>
            </div>
        </div>
    </div>
</div>