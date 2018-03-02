@extends('layouts.app')

@section('body')

<div class="wrapper">
    <h1>Регистрация</h1>
    <form method="POST" action="{{ route('register') }}" class="form">
        @csrf

        <div class="form-group">
            <label for="name">Имя и фамилия</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Имя и фамилия" required autofocus>
        </div>

        <div class="form-group">
            <label for="email">Эл. адресс</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Эл. адресс" required>
        </div>

        <div class="form-group">
            <label for="password">Пароль</label>
            <input type="password" id="password" name="password" placeholder="Пароль" required>
        </div>

        <div class="form-group">
            <label for="password_confirmation">Повторите пароль</label>
            <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Повторите пароль" required>
        </div>

        <div class="form-group">
            <input type="submit" value="Регистрация">
        </div>
    </form>
</div>

@endsection
