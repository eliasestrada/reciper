@extends('layouts.app')

@section('title', trans('settings.titles_home_page'))

@section('content')

<div class="container">
	{{--  Настройки Баннера  --}} {!! Form::open([
		'action' => 'SettingsController@updateBannerData',
		'method' => 'POST',
		'class' => 'form'
	]) !!}

		@method('PUT')

		<div class="form-group">
			<h2 class="form-headline">
				<i class="title-icon" style="background: url('/css/icons/svg/photo.svg')"></i>
				@lang('settings.banner')
			</h2>

			{{ Form::label('title', trans('settings.banner_title')) }}
			{{ Form::text('title', $title_banner->title, [
				'placeholder' => trans('settings.banner_title')
			]) }}

			{{ Form::label('text', trans('settings.banner_text')) }}
			{{ Form::textarea('text', $title_banner->text, [
				'placeholder' => trans('settings.banner_text')
			]) }}
		</div>

		<div class="form-group">
			{{ Form::submit(trans('form.save')) }}
		</div>
	{!! Form::close() !!}

	<hr class="hr" />

	{{--  Настройки Интро  --}} {!! Form::open([
		'action' => 'SettingsController@updateIntroData',
		'method' => 'POST',
		'class' => 'form'
	]) !!}

		@method('PUT')

		<div class="form-group">
			<h2 class="form-headline">
				<i class="title-icon" style="background: url('/css/icons/svg/list-add.svg')"></i>
				@lang('settings.intro')
			</h2>

			{{ Form::label('title', trans('settings.intro_title')) }}
			{{ Form::text('title', $title_intro->title, [
				'placeholder' => trans('settings.intro_title')
			]) }}

			{{ Form::label('text', trans('settings.intro_text')) }}
			{{ Form::textarea('text', $title_intro->text, [
				'placeholder' => trans('settings.intro_text')
			]) }}

			{{ Form::submit(trans('form.save')) }}
		</div>
	{!! Form::close() !!}

	<hr class="hr" />

	{{--  Настройки подвала  --}} {!! Form::open([
		'action' => 'SettingsController@updateFooterData',
		'method' => 'POST',
		'class' => 'form'
	]) !!}

		@method('PUT')

		<div class="form-group">
			<h2 class="form-headline">
				<i class="title-icon" style="background: url('/css/icons/svg/list-add.svg')"></i>
				@lang('settings.footer')
			</h2>

			{{ Form::label('text', trans('settings.footer_text')) }}
			{{ Form::textarea('text', $title_footer->text, [
				'placeholder' => trans('settings.footer_text')
			]) }}

			{{ Form::submit(trans('form.save')) }}
		</div>
	{!! Form::close() !!}
</div>

@endsection