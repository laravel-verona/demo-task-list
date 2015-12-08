@extends('layout')

@section('content')

<div class="row">
    <div class="col-md-6 col-md-offset-3">
        {!! Form::open(['route' => 'auth.register']) !!}
            <h2 class="form-signin-heading">Please sign in</h2>
            {!! Form::text('name', old('name'), ['class' => 'form-control', 'required' => true, 'placeholder' => 'Name']) !!}
            {!! Form::email('email', old('email'), ['class' => 'form-control', 'required' => true, 'placeholder' => 'Email']) !!}
            {!! Form::password('password', ['class' => 'form-control', 'required' => true, 'placeholder' => 'Password']) !!}
            {!! Form::password('password_confirmation', ['class' => 'form-control', 'required' => true, 'placeholder' => 'Password confirmation']) !!}

            {!! Form::submit('Sign up', ['class' => 'btn btn-lg btn-primary btn-block']) !!}
        {!! Form::close() !!}
    </div>
</div>
@endsection