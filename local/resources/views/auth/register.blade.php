@extends('layouts.app')
@section('content')

    <form method="POST" action="{{ route('register') }}" class="form">
        @csrf

        <input id="name" type="text" name="фамилия" value="{{ old('name') }}" placeholder="Фамилия" required autofocus>

        <input id="email" type="email" name="эл.адресс" value="{{ old('email') }}" placeholder="Эл. адресс" required>

        <input id="password" type="password" name="пароль" placeholder="Пароль" required>

        <input id="password-confirm" type="password" name="пароль2" placeholder="Повторите пароль" required>

        <button type="submit" class="button">Регистрация</button>
    </form>

@endsection
