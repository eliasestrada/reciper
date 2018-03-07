@extends('layouts.app')

@section('title', 'Сброс пароля')

@section('content')

<div class="wrapper">

	@if (session('status'))
		<div class="alert alert-success">
			{{ session('status') }}
		</div>
	@endif

	<form method="POST" action="{{ route('password.email') }}" class="form">
		@csrf

		<div class="form-group">
			<label for="email">Эл. почта</label>
			<input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="Эл. почта" required>
		</div>

		<div class="form-group">
			<input type="submit" value="Отослать пароль ссылку на почту">
		</div>
	</form>
</div>
@endsection
