@extends('layouts.app')

@section('title', 'Связь с нами')

@section('content')

<div class="wrapper">
	<div class="container">
		<h1 class="headline">Связь с нами</h1>
		<p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ut, consequatur.</p>
		<br>

		<form action="{{ route('contact.store') }}" method="POST" class="form">
			@csrf
			<div class="form-group">
				<input type="text" name="имя" placeholder="Имя">
			</div>
			<div class="form-group">
				<input type="text" name="почта" placeholder="Эл. почта">
			</div>
			<div class="form-group">
				<textarea name="сообщение" placeholder="Введите сообщение"></textarea>
			</div>
			<div class="form-group">
				<input type="submit" value="Отправить">
			</div>
		</form>
	</div>
</div>

@endsection