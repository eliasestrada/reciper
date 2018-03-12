@extends('layouts.user')

@section('title', 'Настройки')

@section('head')
	<style>#settings { border-bottom: 3px solid #a8a8a8; }</style>
@endsection

@section('content')

<div class="wrapper">
	<h2 class="headline">Настройки</h2>
	<p class="content center">Единственное требование к выбору изображению это соотношение его сторон, оно долно быть квадратное, в противном случае изображение будет искажено.</p>

	{{--  Upload image  --}}
	{!! Form::open(['action' => ['SettingsController@updatePhoto', null], 'method' => 'post', 'class' => 'form', 'enctype' => 'multipart/form-data']) !!}
		<div class="form-group">

			<div class="profile-header" style="height: 11em;">
				<img src="{{ asset('storage/uploads/'.$user->image) }}" alt="{{$user->name}}" />
			</div>
			<br />

			{{ Form::hidden('delete', 0) }}
			{{ Form::file('изображение', ['class' => "upload-image-form"]) }}
			{{ Form::hidden('_method', 'PUT') }}
			{{ Form::submit('Сохранить') }}
		</div>
	{!! Form::close() !!}

	{{--  Delete image  --}}
	{!! Form::open(['action' => ['SettingsController@updatePhoto', null], 'method' => 'post', 'class' => 'form', 'enctype' => 'multipart/form-data']) !!}
		<div class="form-group">
			{{ Form::hidden('delete', 1) }}
			{{ Form::hidden('_method', 'PUT') }}
			{{ Form::submit('Удалить', ['style' => 'background: brown; margin-top: -2.3rem;']) }}
		</div>
	{!! Form::close() !!}
</div>

@endsection