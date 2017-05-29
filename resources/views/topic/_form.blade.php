<div class="form-group">
  {!! Form::label('title', '标题') !!}
  {!! Form::text('title', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
  {!! Form::label('topic_node', '节点') !!}
  {!! Form::select('topic_node_id', $nodes, null, ['id' => 'topic_node_id', 'class' => 'form-control']) !!}
</div>

<div class="form-group">
  {!! Form::label('content', '正文') !!}
  {!! Form::textarea('content', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
  {!! Form::submit('确定', ['class' => ' btn btn-primary form-control']) !!}
</div>