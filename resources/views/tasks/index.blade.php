@extends('layout')

@section('content')
<div class="tasks-cont">
    <h2 class="page-header">{{ trans('app.tasks.title') }}</h2>

    <div class="input-group">
        {!! Form::text('task',null, ['class' => 'form-control', 'placeholder' => trans('app.tasks.insert')]) !!}

        <span class="input-group-btn">
            <button class="btn btn-success add-task">
                <span class="glyphicon glyphicon-plus"></span>
            </button>
        </span>
    </div>

    <div class="tasks-list">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th></th>
                        <th>{{ trans('app.tasks.fields.name') }}</th>
                        <th>{{ trans('app.common.created_by') }}</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tasks as $task)
                    <tr>
                        <td class="col-md-1 text-center">{!! Form::checkbox('done', true, $task->done) !!}</td>
                        <td>{{ $task->task }}</td>
                        <th></th>
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

@section('scriptsxsss')
<script>
$(function() {
    $('.add-task').on('click', function(e) {
        e.preventDefault();
        var task = $('input[name=task]').val();

        if (!task) return;

        $.ajax({
            method: 'POST',
            url: "{{ route('tasks.store') }}",
            data: {
                task: task,
                _token: "{{ csrf_token() }}",
            },
            success: function(task) {
                var html =
                "<li class='ui-state-default' data-id='" + tasks.id + "'>" +
                "   <div class='checkbox'>" +
                "       <label>" +
                "               <input type='checkbox' name='done' value='true'>" +
                "               <img class='img-responsive' src='" + tasks.author.gravatar_url + "'>" +
                                tasks.task +
                "       </label>" +
                "   </div>" +
                "   <button class='btn btn-danger destroy'>X</button>" +
                "</li>";

                $('.tasks').append(html);
            },
        });
    });

    $(document).on('change', 'input[name=done]', function(e) {
        e.preventDefault();
        var done = $(this).is(':checked') ? 1 : 0;
        var id      = $(this).closest('li').data('id');

        $.ajax({
            method: 'PUT',
            url: "{{ route('tasks.store') }}" + "/" + id,
            data: {
                done: done,
                _token: "{{ csrf_token() }}",
            },
            success: function(task) {
            },
        });
    });

    $(document).on('click', '.destroy', function(e) {
        e.preventDefault();
        var $li = $(this).closest('li');
        var id  = $li.data('id');

        $.ajax({
            method: 'DELETE',
            url: "{{ route('tasks.store') }}" + "/" + id,
             data: {
                _token: "{{ csrf_token() }}",
            },
            success: function(task) {
                $li.remove();
            },
        });
    });
});
</script>
@endsection
