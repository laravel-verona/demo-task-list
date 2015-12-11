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
                            <a href="#" class="task-name" data-toggle="modal" data-target="#taskModal" data-id="{{ $task->id }}" data-name="{{ $task->name }}" data-url="{{ route('tasks.update', $task->id) }}">
                                {{ $task->name }}
                            </a>
                        </td>
                        <td class="col-md-3">
                            {{ $task->author ? $task->author->name : null }}
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


<div class="modal fade" id="taskModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            {!! Form::open(['method' => 'PUT', 'class' => 'task-update']) !!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">{{ trans('app.tasks.sing') }}</h4>
                </div>
                <div class="modal-body">
                    {!! Form::text('name', null, ['class' => 'form-control']) !!}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('app.actions.close') }}</button>
                    <button type="submit" class="btn btn-primary">{{ trans('app.actions.save') }}</button>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(function()
{
    $('input[name=done]').on('change', function(event) {
        $(this).parent().submit();
    });

    $('#taskModal').on('show.bs.modal', function(event) {
      var link = $(event.relatedTarget);

      $(this).find('.modal-body input').val(link.data('name'));
      $(this).find('.modal-content form').attr('action', link.data('url'));
    });

    $('#taskModal').on('shown.bs.modal', function(event) {
      $(this).find('.modal-body input').focus().select();
    });
})
</script>
@endsection
