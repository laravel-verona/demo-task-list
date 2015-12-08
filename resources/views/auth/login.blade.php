@extends('layout')

@section('content')

<div class="row">
    <div class="col-md-6 col-md-offset-3">
        {!! Form::open(['route' => 'auth.login']) !!}
            <h2 class="form-signin-heading">Please sign in</h2>
            {!! Form::email('email', old('email'), ['class' => 'form-control', 'required' => true, 'placeholder' => 'Email']) !!}
            {!! Form::password('password', ['class' => 'form-control', 'required' => true, 'placeholder' => 'Password']) !!}
            <div class="checkbox">
                <label>
                    {!! Form::checkbox('remember', true) !!}
                    Remember me
                </label>
            </div>

            {!! Form::submit('Sign in', ['class' => 'btn btn-lg btn-primary btn-block']) !!}
        {!! Form::close() !!}
    </div>
</div>
@endsection