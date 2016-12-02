@extends('layouts.dashboard')

@section('content')
<style>
.section-editbox.disnone {
    display: none;
}

a[disabled] {
    pointer-events: none;
}

.list-group-item:hover .section-editbox {
    display: block !important;
}

.modal .modal-dialog {
    margin-top: 140px;
}
</style>

<script>
function nodeDestory(type, id) {
    if (confirm('{{ trans('dashboard.Delete the node will also delete the topic under the node, are you sure?') }}')) {
        var eStr = '#form-' + type + '-' + id;
        $(eStr).submit();
    }
}

function nodeRenamePretreatment(id, name) {
    var form = '#form-node-rename';
    $(form).find('input[name="id"]').val(id);
    $(form).find('input[name="name"]').val(name);
}
</script>
<div class="container">
    <div class="row">
        <div class="col-sm-2">
            @include('dashboard.topic._sidenav')
        </div>

        <div class="col-sm-10">
            <div id="section-breadcrumb">
                <ol class="breadcrumb">
                    <li><a href="{{ url('/dashboard') }}">HeyCommunity</a></li>
                    <li><a href="{{ url('/dashboard/topic') }}">{{ trans('dashboard.Topic') }}</a></li>
                    <li class="active">{{ trans('dashboard.Nodes') }}</li>
                </ol>
            </div>

            <div id="section-mainbody" style="margin-top:80px;">
                <div class="pull-right" style="margin-top:-50px;">
                    <button data-toggle="modal" data-target="#nodeAddModal" class="btn btn-default btn-sm">
                        <i class="glyphicon glyphicon-plus"></i> {{ trans('dashboard.New Node') }}
                    </button>
                    <button onclick="$('.section-editbox').fadeToggle()" class="hide btn btn-default btn-sm">&nbsp;<i class="glyphicon glyphicon-cog"></i>&nbsp;</button>
                </div>
                <div class="row">
                @foreach ($rootNodes as $k => $rootNode)
                    <div class="col-sm-4">
                        <div class="list-group">
                            <div class="list-group-item active">
                                <span class="text-muted">#{{ $k+1 }}</span> {{ $rootNode->name }}
                                <div class="pull-right section-editbox {{ Input::get('edit') === 'true' ? 'disnone' : 'disnone' }}">
                                    <button onclick="nodeDestory('rootNode', {{ $rootNode->id }})" {{ ($rootNode->getDescendants()->count()) ? 'disabled' : '' }} class="btn btn-danger btn-xs">
                                        <i class="glyphicon glyphicon-trash"></i>
                                    </button>
                                    {!! Form::open(['url' => url('/dashboard/topic/node-destroy'), 'id' => ('form-rootNode-' . $rootNode->id), 'class' => 'hidden', 'method' => 'post']) !!}
                                        <input type="hidden" name="id" value="{{ $rootNode->id }}">
                                        {!! Form::submit('Submit', ['class' => 'btn btn-xs']) !!}
                                    {!! Form::close() !!}

                                    &nbsp;&nbsp;
                                    <a href="{{ url('dashboard/topic/node-move-left?id=' . $rootNode->id) }}" {{ $k === 0 ? 'disabled' : '' }} class="btn btn-default btn-xs">
                                        <i class="glyphicon glyphicon-arrow-left"></i>
                                    </a>
                                    <a href="{{ url('dashboard/topic/node-move-right?id=' . $rootNode->id) }}" {{ $k === ($rootNodes->count() - 1) ? 'disabled' : '' }} class="btn btn-default btn-xs">
                                        <i class="glyphicon glyphicon-arrow-right"></i>
                                    </a>
                                    <button onclick="nodeRenamePretreatment({{ $rootNode->id }}, '{{ $rootNode->name }}')" data-toggle="modal" data-target="#nodeRenameModal" class="btn btn-default btn-xs"><i class="glyphicon glyphicon-pencil"></i></button>
                                </div>
                            </div>
                            @foreach ($rootNode->getDescendants() as $k => $node)
                                <div class="list-group-item">
                                    {{ $node->name }}
                                    <div class="pull-right section-editbox {{ Input::get('edit') === 'true' ? 'disnone' : 'disnone' }}">
                                        <button onclick="nodeDestory('node', {{ $node->id }})" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i></button>
                                        {!! Form::open(['url' => url('/dashboard/topic/node-destroy'), 'id' => ('form-node-' . $node->id), 'class' => 'hidden', 'method' => 'post']) !!}
                                            <input type="hidden" name="id" value="{{ $node->id }}">
                                            {!! Form::submit('Submit', ['class' => 'btn btn-xs']) !!}
                                        {!! Form::close() !!}
                                        &nbsp;&nbsp;

                                        <a href="{{ url('dashboard/topic/node-move-left?id=' . $node->id) }}" {{ $k === 0 ? 'disabled' : '' }} class="btn btn-default btn-xs">
                                            <i class="glyphicon glyphicon-arrow-up"></i>
                                        </a>
                                        <a href="{{ url('dashboard/topic/node-move-right?id=' . $node->id) }}" {{ $k === ($rootNode->getDescendants()->count() - 1) ? 'disabled' : '' }} class="btn btn-default btn-xs">
                                            <i class="glyphicon glyphicon-arrow-down"></i>
                                        </a>
                                        <button onclick="nodeRenamePretreatment({{ $node->id }}, '{{ $node->name }}')" data-toggle="modal" data-target="#nodeRenameModal" class="btn btn-default btn-xs"><i class="glyphicon glyphicon-pencil"></i></button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="nodeAddModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">{{ trans('dashboard.Add Node') }}</h4>
            </div>
            <div class="modal-body">
                <br>
                {!! Form::open(['url' => url('/dashboard/topic/node-add'), 'id' => 'form-node-add', 'class' => 'form form-horizontal', 'method' => 'post']) !!}
                    <div class="form-group {{ $errors->has('parent_id') ? 'has-error' : '' }}">
                        <label for="input-parend_id" class="col-sm-4 control-label">{{ trans('dashboard.Parent Node') }}</label>
                        <div class="col-sm-6">
                            <select name="parent_id" class="form-control">
                                <option value="0">{{ trans('dashboard.Root Node') }}</option>
                                @foreach ($rootNodes as $node)
                                <option value="{{ $node->id }}">{{ $node->name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('parent_id'))
                            <div class="help-block">{{ $errors->first('parent_id') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                        <label for="input-name" class="col-sm-4 control-label">{{ trans('dashboard.Node Name') }}</label>
                        <div class="col-sm-6">
                            <input type="string" name="name" class="form-control" id="input-name" placeholder="" value="{{ old('name') }}">
                            @if ($errors->has('name'))
                                <div class="help-block">{{ $errors->first('name') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-4 col-sm-6">
                            <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('dashboard.Close') }}</button>
                            <button type="submit" class="btn btn-primary">{{ trans('dashboard.Save') }}</button>
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="nodeRenameModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">{{ trans('dashboard.Rename Node') }}</h4>
            </div>
            <div class="modal-body">
                <br>
                {!! Form::open(['url' => url('/dashboard/topic/node-rename'), 'id' => 'form-node-rename', 'class' => 'form form-horizontal', 'method' => 'post']) !!}
                    <input type="hidden" name="id" value="null">
                    <div class="form-group">
                        <label for="input-name" class="col-sm-4 control-label">{{ trans('dashboard.Node Name') }}</label>
                        <div class="col-sm-6">
                            <input type="string" name="name" class="form-control" id="input-name" placeholder="" value="">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-4 col-sm-6">
                            <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('dashboard.Close') }}</button>
                            <button type="submit" class="btn btn-primary">{{ trans('dashboard.Save') }}</button>
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection

