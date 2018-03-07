@extends('layouts.app')

@section('title', 'Сбросить пароль')

@section('content')

<div class="wrapper">
	<h2 class="headline">Сбросить пароль</h2>

	<form method="POST" action="{{ route('password.email') }}" class="form">
		@csrf

		<div class="form-group">
			<label for="email">Эл. почта</label>
			<input id="email" type="email" name="email" placeholder="Эл. почта" required>
		</div>

		<div class="form-group">
			<input type="submit" value="Отослать пароль ссылку на почту">
		</div>
	</form>
</div>
@endsection
