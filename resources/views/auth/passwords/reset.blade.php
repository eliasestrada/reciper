@extends('layouts.app')

@section('title', 'Сброс пароля')

@section('content')

<div class="wrapper">
	<h2 class="headline">Сброс пароля</h2>
	<form method="POST" action="{{ route('password.request') }}" class="form">
		@csrf

		<input type="hidden" name="token" value="{{ $token }}">

		<div class="form-group">
			<label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>

			<input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $email or old('email') }}" required autofocus>

			@if ($errors->has('email'))
				<span class="invalid-feedback">
					<strong>{{ $errors->first('email') }}</strong>
				</span>
			@endif
		</div>

		<div class="form-group">
			<label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

			<input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

			@if ($errors->has('password'))
				<span class="invalid-feedback">
					<strong>{{ $errors->first('password') }}</strong>
				</span>
			@endif
		</div>

		<div class="form-group">
			<label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirm Password</label>
			<input id="password-confirm" type="password" class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" name="password_confirmation" required>

			@if ($errors->has('password_confirmation'))
				<span class="invalid-feedback">
					<strong>{{ $errors->first('password_confirmation') }}</strong>
				</span>
			@endif
		</div>

		<div class="form-group">
			<button type="submit" class="btn btn-primary">
				Сбросить пароль
			</button>
		</div>
	</form>
</div>

@endsection
