@extends('layouts.app')

@section('title', 'Войти')

@section('content')

<h2 class="headline">Войти</h2>
<form method="POST" action="{{ route('login') }}" class="form">
	@csrf

	<div class="form-group">
		{{ Form::label('email', 'Эл. адрес') }}
		{{ Form::email('email', null, ['placeholder' => 'Эл. адрес']) }}
	</div>

	<div class="form-group">
		{{ Form::label('password', 'Пароль') }}
		{{ Form::password('password', ['placeholder' => 'Пароль']) }}
	</div>
	
	<div class="form-group" style="display:flex;">
		<input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Запомнить меня
	</div>

	<div class="form-group">
		{{ Form::submit('Войти') }}
	</div>

	<a href="{{ route('password.request') }}">Забыли пароль?</a>
</form>
<div class="spacer"></div>

@endsection
