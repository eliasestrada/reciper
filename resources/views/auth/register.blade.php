@extends('layouts.app')

@section('title', 'Регистрация')

@section('content')

<h2 class="headline">Регистрация</h2>
<form method="POST" action="{{ route('register') }}" class="form">
	@csrf

	<div class="form-group">
		<label for="name">Это имя будет отображаться на всех ваших рецептах</label>
		<input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Имя" required autofocus>
	</div>

	<div class="form-group">
		<label for="email">Эл. адрес</label>
		<input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Эл. адрес" required>
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
<div class="spacer"></div>

@endsection
