@extends('layouts.user')

@section('title', 'Заголовки')

@section('head')
	<style>#settings { border-bottom: 3px solid #a8a8a8; }</style>
@endsection

@section('content')

	<h2 class="headline">Заголовки главной страницы</h2>

	<h4 class="headline">Заголовок Баннера</h4>
	{!! Form::open(['action' => 'SettingsController@updateBannerData', 'method' => 'POST', 'class' => 'form']) !!}

		@method('PUT')

		<div class="form-group">
			{{ Form::label('title', 'Заголовок баннера') }}
			{{ Form::text('title', $title_banner->title, ['placeholder' => 'Заголово баннера']) }}
		</div>

		<div class="form-group">
			{{ Form::label('text', 'Содержание баннера') }}
			{{ Form::textarea('text', $title_banner->text, ['placeholder' => 'Содержание баннера']) }}
		</div>

		<div class="form-group">
			{{ Form::submit('Сохранить') }}
		</div>
	
	{!! Form::close() !!}

@endsection