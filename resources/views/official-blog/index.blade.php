@extends('layouts.home')

@section('content')
<div id="getting-started">
  <br>
  <br>
  <br>
  <br>

  <div class="container">
    <div class="row">
      <div class="col-sm-4 col-lg-3">
        <ul class="list-unstyled">
          @foreach ($blogs as $blog)
            <li style="margin-bottom:2px;"><span style="color:#666">[{{ $blog->created_at->format('m-d') }}]</span> &nbsp;&nbsp; <a style=""href="{{ route('blog.show', ['id' => $blog->id]) }}">{{ $blog->title }}</a></li>
          @endforeach
        </ul>
      </div>

      <div class="col-sm-8 col-lg-9" style="padding-left:60px;">
        <div class="text-left">
          <h1 class="h3">{{ $blog->title }}</h1>
          <p>{{ $blog->content }}</p>
        </div>
      </div>
    </div>
  </div>

  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
</div>
@endsection
