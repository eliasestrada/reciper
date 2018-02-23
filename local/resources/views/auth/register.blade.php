@extends('layouts.app')
@section('content')

    <h1>Регистрация</h1>
    <form method="POST" action="{{ route('register') }}" class="form">
        @csrf

        <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Фамилия" required autofocus>

        <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Эл. адресс" required>

        <input type="password" id="password" name="password" placeholder="Пароль" required>

        <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Повторите пароль" required>

        <button type="submit" class="button">Регистрация</button>
    </form>

@endsection
