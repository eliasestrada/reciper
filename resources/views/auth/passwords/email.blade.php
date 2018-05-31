@extends('layouts.app')

@section('title', 'Отправка кода')

@section('content')

<div class="wrapper">
	<h2 class="headline">Отправить код</h2>
	<p class="content text-center">После отправки этой формы, на вашу электронную почту прийдет сообщение с ссылкой на сброс пароля, перейдя по этой ссылке вы попадете на страницу где сможете ввести свой новый пароль.</p>

	@if (session('status'))
		<div class="message success">{{ session('status') }}</div>
	@endif

	<form method="POST" action="{{ route('password.email') }}" class="form">
		@csrf

		<div class="form-group">
			<label for="email">Эл. адрес</label>
			<input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="Эл. адрес" required>

			@if ($errors->has('email'))
				<span class="message error"style="background:none;">
					{{ $errors->first('email') }}
				</span>
			@endif
		</div>

		<div class="form-group">
			<input type="submit" value="Отправить код">
		</div>
	</form>
</div>

@endsection
