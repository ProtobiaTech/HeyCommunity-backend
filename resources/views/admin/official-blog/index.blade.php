@extends('layouts.admin')

@section('content')
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
                    <li class="active">{{ trans('dashboard.List') }}</li>
                </ol>
            </div>

            <div id="section-mainbody">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>{{ trans('dashboard.Title') }}</th>
                            <th>{{ trans('dashboard.Created At') }}</th>
                            <th>{{ trans('dashboard.Operation') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($blogs as $blog)
                        <tr>
                            <td>{{ $blog->id }}</td>
                            <td>{{ $blog->title }}</td>
                            <td>{{ $blog->created_at }}</td>
                            <td>
                                <a href="{{ route('admin.blog.edit', ['id' => $blog->id]) }}" class="btn btn-default btn-xs">{{ trans('dashboard.Edit') }}</a>
                                <a href="javascript:if (confirm('{{ trans('dashboard.Are you sure?') }}')) { $('#form-blog-destroy-{{ $blog->id }}').submit(); }" class="btn btn-danger btn-xs">{{ trans('dashboard.Delete') }}</a>
                                {!! Form::open(['url' => route('admin.blog.destroy', ['id' => $blog->id]), 'id' => ('form-blog-destroy-' . $blog->id), 'class' => 'hidden', 'method' => 'DELETE']) !!}
                                    <input type="hidden" name="id" value="{{ $blog->id }}">
                                    {!! Form::submit('Submit', ['class' => 'btn btn-xs']) !!}
                                {!! Form::close() !!}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div>
                    {!! $blogs->render() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

