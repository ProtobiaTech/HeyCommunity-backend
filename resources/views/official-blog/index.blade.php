@extends('layouts.home')

@section('content')
<div id="getting-started">
  <div class="container">
    <div class="row">
      <div class="col-sm-4" style="padding-right:50px;">
        <ul class="list-unstyled" style="margin-bottom:60px;">
          @foreach ($blogs as $item)
            <li style="margin-bottom:2px;"><span style="color:#666">[{{ $item->created_at->format('m-d') }}]</span> &nbsp;&nbsp; <a style=""href="{{ route('blog.show', ['id' => $item->id]) }}">{{ $item->title }}</a></li>
          @endforeach
        </ul>
      </div>

      <div class="col-sm-8" style="">
        @if ($blog)
        <div class="text-left">
          <h1 class="">{{ $blog->title }}</h1>
          <div style="margin-top:-20px;" class="text-muted">{{ $blog->author->nickname }} 发布于 {{ $blog->created_at }}</div>
          <hr>
          <p>{!! $blog->content !!}</p>
        </div>
        @else
        <h1 class=""># Null</h1>
        <div>暂无内容</div>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection
