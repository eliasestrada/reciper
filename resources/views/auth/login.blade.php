@extends('layouts.app')

@section('content')

    <h1>Войти</h1>
    <form method="POST" action="{{ route('login') }}" class="form">
        @csrf

        <div class="form-group">
            {{ Form::label('email', 'Эл. адресс') }}
            {{ Form::email('email', null, ['placeholder' => 'Эл. адресс']) }}
        </div>

        <div class="form-group">
            {{ Form::label('password', 'Пароль') }}
            {{ Form::password('password', null, ['placeholder' => 'Пароль']) }}
        </div>

        {{--
            <div class="form-group">
                Tip: I don't need this for the first time
                <label>
                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Запомнить меня
                </label>
            </div>
        --}}

        <div class="form-group">
            {{ Form::submit('Войти') }}
        </div>

        <a class="btn btn-link" href="{{ route('password.request') }}">Забыли пароль?</a>
    </form>

@endsection
