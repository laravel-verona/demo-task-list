@extends('layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="todolist not-done">
             <h1>Todos</h1>
             {!! Form::text('task',null, ['class' => 'form-control']) !!}
             <button class="btn btn-success add-task">Add</button>

             <hr>
             <ul id="sortable" class="list-unstyled tasks">
                @foreach ($tasks as $task)
                    <li class="ui-state-default" data-id="{{ $task->id }}">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('done', true, $task->done) !!}
                                <img class="img-responsive" src="{{ $task->author->gravatar_url }}">
                                {{ $task->task }}
                            </label>
                        </div>
                        <button class="btn btn-danger destroy">X</button>
                    </li>
                @endforeach
            </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(function() {
    $('.add-task').on('click', function(e) {
        e.preventDefault();
        var task = $('input[name=task]').val();

        if (!task) return;

        $.ajax({
            method: 'POST',
            url: "{{ route('task.store') }}",
            data: {
                task: task,
                _token: "{{ csrf_token() }}",
            },
            success: function(task) {
                var html =
                "<li class='ui-state-default' data-id='" + task.id + "'>" +
                "   <div class='checkbox'>" +
                "       <label>" +
                "               <input type='checkbox' name='done' value='true'>" +
                "               <img class='img-responsive' src='" + task.author.gravatar_url + "'>" +
                                task.task +
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
            url: "{{ route('task.store') }}" + "/" + id,
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
            url: "{{ route('task.store') }}" + "/" + id,
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


