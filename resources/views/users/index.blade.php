@extends('layout')

@section('content')
<div class="users-cont">
    <h2 class="page-header">{{ trans('app.users.title') }}</h2>

    <div class="users-list">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{{ trans('app.users.fields.id') }}</th>
                        <th>{{ trans('app.users.fields.name') }}</th>
                        <th>{{ trans('app.users.fields.email') }}</th>
                        <th>{{ trans('app.common.created_at') }}</th>
                        <th>{{ trans('app.common.updated_at') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->created_at }}</td>
                        <td>{{ $user->updated_at }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td class="empty" colspan="5">{{ trans('app.users.empty') }}</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
