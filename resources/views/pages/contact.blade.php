@extends('layouts.app')

@section('title', 'Связь с нами')

@section('content')

<div class="container">
	<h1 class="headline">Связь с нами</h1>

	{!! Form::open(['action' => 'ContactController@store', 'method' => 'POST', 'class' => 'form']) !!}
		@csrf
		<div class="form-group simple-group">
			{{ Form::label('имя', 'Имя') }}
			{{ Form::text('имя', '', ['placeholder' => 'Введите ваше имя']) }}
		</div>
		<div class="form-group simple-group">
			{{ Form::label('почта', 'Эл. почта') }}
			{{ Form::text('почта', '', ['placeholder' => 'Введите эл. почту']) }}
		</div>
		<div class="form-group simple-group">
			{{ Form::label('сообщение', 'Cообщение') }}
			{{ Form::textarea('сообщение', '', ['placeholder' => 'Введите сообщение']) }}
		</div>
		<div class="form-group simple-group">
			{{ Form::submit('Отправить') }}
		</div>
	{!! Form::close() !!}
</div>

@endsection