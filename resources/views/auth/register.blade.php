@extends('auth.layout')

@section('body')
<div class="form-cont register-cont">
    {!! Form::open(['route' => 'auth.register']) !!}
        <h2 class="page-header">{{ trans('app.auth.register.title') }}</h2>

        @include('partials.alert')

        {!! Form::text('name', null, ['class' => 'form-control input-lg', 'placeholder' => trans('app.auth.register.fields.name'), 'autofocus' => true]) !!}
        {!! Form::email('email', null, ['class' => 'form-control input-lg', 'placeholder' => trans('app.auth.register.fields.email')]) !!}
        {!! Form::password('password', ['class' => 'form-control input-lg', 'placeholder' => trans('app.auth.register.fields.password')]) !!}
        {!! Form::password('password_confirmation', ['class' => 'form-control input-lg', 'placeholder' => trans('app.auth.register.fields.password_confirmation')]) !!}

        <button type="submit" class="btn btn-block btn-lg btn-primary">
            {{ trans('app.auth.register.submit') }}
        </button>
    {!! Form::close() !!}

    <div class="auth-actions">
        <a href="{{ route('auth.login') }}">
            {{ trans('app.auth.register.login') }}
        </a>
    </div>
</div>
@endsection
