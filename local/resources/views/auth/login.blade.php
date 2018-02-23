@extends('layouts.app')
@section('content')

    <form method="POST" action="{{ route('login') }}" class="form">
        @csrf

        <input type="email" name="email" value="{{ old('email') }}" placeholder="Эл. адресс" required autofocus>

        <input type="password" name="password" placeholder="Пароль" required>
        
        <label>
            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Запомнить меня
        </label>

        <button type="submit" class="button">Войти</button>

        <a class="btn btn-link" href="{{ route('password.request') }}">
            Забыли пароль?
        </a>
    </form>

@endsection
