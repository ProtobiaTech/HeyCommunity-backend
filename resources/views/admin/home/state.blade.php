@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="text-center">
        <h2>Hey Community</h2>
    </div>

    <!-- Login panel -->
    <div class="row" style="margin-top:30px;">
        <div class="col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Timeline State
                </div>
                <div class="panel-body">
                    Total: {{ $timelines->count() }}
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Activity State
                </div>
                <div class="panel-body">
                    Total:: {{ $activities->count() }}
                </div>
            </div>
        </div>

        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    User State
                </div>
                <div class="panel-body">
                    Total: {{ $users->total() }}
                    <table class="table">
                        @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->email }}</td>
                        </tr>
                        @endforeach
                    </table>
                    {!! $users->render() !!}
                </div>
            </div>
        </div>

        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Tenant State
                </div>
                <div class="panel-body">
                    Total: {{ $tenants->total() }}
                    <table class="table">
                        @foreach ($tenants as $tenant)
                        <tr>
                            <td>{{ $tenant->id }}</td>
                            <td>{{ $tenant->email }}</td>
                            <td>{{ $tenant->domain }}</td>
                        </tr>
                        @endforeach
                    </table>
                    {!! $tenants->render() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
