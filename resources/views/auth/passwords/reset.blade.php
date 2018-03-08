@extends('layouts.app')

@section('title', 'Сброс пароля')

@section('content')

<div class="wrapper">
	<h2 class="headline">Сброс пароля</h2>

	<form method="POST" action="{{ route('password.request') }}" class="form">
		@csrf

		<input type="hidden" name="token" value="{{ $token }}">

		<div class="form-group">
			<label for="email">Эл. адрес</label>

			<input id="email" type="email" name="email" value="{{ $email or old('email') }}" placeholder="Эл. адрес" required autofocus>

			@if ($errors->has('email'))
				<span class="message error" style="background:none;">
					{{ $errors->first('email') }}
				</span>
			@endif
		</div>

		<div class="form-group">
			<label for="password">Новый пароль</label>

			<input id="password" type="password" placeholder="Новый пароль" name="password" required>

			@if ($errors->has('password'))
				<span class="message error" style="background:none;">
					{{ $errors->first('password') }}
				</span>
			@endif
		</div>

		<div class="form-group">
			<label for="password-confirm">Повторите новый пароль</label>
			<input id="password-confirm" type="password" name="password_confirmation" placeholder="Повторите новый пароль" required>

			@if ($errors->has('password_confirmation'))
				<span class="message error" style="background:none;">
					{{ $errors->first('password_confirmation') }}
				</span>
			@endif
		</div>

		<div class="form-group">
			<input type="submit" value="Сбросить пароль">
		</div>
	</form>
</div>

@endsection
