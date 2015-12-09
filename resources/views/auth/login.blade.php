@extends('auth.layout')

@section('body')
<div class="form-cont login-cont">
    {!! Form::open() !!}
        <h2 class="page-header">{{ trans('app.auth.login.title') }}</h2>

        @include('partials.alert')

        {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => trans('app.auth.login.fields.email'), 'autofocus' => true]) !!}
        {!! Form::password('password', ['class' => 'form-control', 'placeholder' => trans('app.auth.login.fields.password')]) !!}

        <div class="checkbox">
            <label>
                {!! Form::checkbox('remember', true) !!} {{ trans('app.auth.login.remember') }}
            </label>
        </div>

        <button type="submit" class="btn btn-block btn-lg btn-primary">
            {{ trans('app.auth.login.submit') }}
        </button>
    {!! Form::close() !!}

    <div class="auth-actions">
        <a href="{{ url('auth/register') }}">{{ trans('app.auth.login.register') }}</a>
    </div>
</div>
@endsection
