@extends('layouts.app')

@section('title', 'Общие Настройки')

@section('content')

	<h3>Общие настройки</h3>

	{!! Form::open(['action' => 'SettingsController@updateUserData', 'method' => 'POST', 'class' => 'form']) !!}

		@method('PUT')

		<div class="form-group">
			{{ Form::label('name', 'Имя') }}
			{{ Form::text('name', auth()->user()->name, ['placeholder' => 'Ваше имя']) }}
		</div>

		<div class="form-group">
			{{ Form::submit('Сохранить') }}
		</div>

	{!! Form::close() !!}

	<h3>Изменение пароля</h3>

	{!! Form::open(['action' => 'SettingsController@updateUserPassword', 'method' => 'POST', 'class' => 'form']) !!}

		@method('PUT')

		<div class="form-group">
			{{ Form::label('old_password', 'Ваш текущий пароль') }}
			{{ Form::password('old_password', ['placeholder' => 'Ваш текущий пароль']) }}
		</div>

		<div class="form-group">
			{{ Form::label('password', 'Новый пароль') }}
			{{ Form::password('password', ['placeholder' => 'Новый пароль']) }}
		</div>

		<div class="form-group">
			{{ Form::label('password_confirmation', 'Повторите новый пароль') }}
			{{ Form::password('password_confirmation', ['placeholder' => 'Повторите новый пароль']) }}
		</div>

		<div class="form-group">
			{{ Form::submit('Сохранить') }}
		</div>

	{!! Form::close() !!}

@endsection