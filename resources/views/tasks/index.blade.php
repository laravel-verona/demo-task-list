@extends('layout')

@section('content')
<div class="tasks-cont">
    <h2 class="page-header">{{ trans('app.tasks.title') }}</h2>

    @include('partials.alert')

    {!! Form::open(['route' => 'tasks.store']) !!}
        <div class="input-group">
            {!! Form::text('name',null, ['class' => 'form-control', 'placeholder' => trans('app.tasks.insert'), 'autofocus' => true]) !!}

            <span class="input-group-btn">
                <button type="submit" class="btn btn-success">
                    <span class="glyphicon glyphicon-plus"></span>
                </button>
            </span>
        </div>
    {!! Form::close() !!}

    <div class="tasks-list">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th class="text-center">{{ trans('app.tasks.fields.done') }}</th>
                        <th>{{ trans('app.tasks.fields.name') }}</th>
                        <th>{{ trans('app.common.created_by') }}</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tasks as $task)
                    <tr class="{{ $task->done ? 'done' : 'undone' }}">
                        <td class="col-md-1 text-center">
                            {!! Form::open(['route' => ['tasks.update', $task->id], 'method' => 'PUT']) !!}
                                {!! Form::checkbox('done', true, $task->done) !!}
                            {!! Form::close() !!}
                        </td>
                        <td class="col-md-6">
                            {{ $task->name }}
                        </td>
                        <td class="col-md-3">
                            {{ $task->author->name }}
                            <div class="text-muted">
                                <small>{{ $task->created_at }}</small>
                            </div>
                        </td>
                        <td class="actions">
                            {!! formDelete(route('tasks.destroy', $task->id)) !!}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td class="empty" colspan="4">{{ trans('app.tasks.empty') }}</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(function()
{
    $(document).on('change', 'input[name=done]', function(e) {
        $(this).parent().submit();
    });
})
</script>
@endsection
