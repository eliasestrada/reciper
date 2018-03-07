@extends('layouts.app')

@section('title', 'Сброс пароля')

@section('content')

<div class="wrapper">
	<h2 class="headline">Сброс пароля</h2>

	<form method="POST" action="{{ route('password.request') }}" class="form">
		@csrf

		<input type="hidden" name="token" value="{{ $token }}">

		<div class="form-group">
			<label for="email">Эл. почта</label>
			<input id="email" type="email" placeholder="Эл. почта" value="{{ $email }}" required autofocus>
		</div>

		<div class="form-group">
			<label for="password">Пароль</label>
			<input id="password" type="password" name="password" required>
		</div>

		<div class="form-group">
			<label for="password-confirm" >Повторите пароль</label>
			<input id="password-confirm" type="password" name="password_confirmation" required>
		</div>

		<div class="form-group">
			<input type="submit" value="Сбросить пароль">
		</div>
	</form>
</div>

@endsection
