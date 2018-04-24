@extends('layouts.app')

@section('title', trans('settings.general'))

@section('content')

<h3>@lang('settings.general')</h3>

{!! Form::open(['action' => 'SettingsController@updateUserData', 'method' => 'POST', 'class' => 'form']) !!}

	@method('PUT')

	<div class="form-group simple-group">
		{{ Form::label('name', trans('form.name')) }}
		{{ Form::text('name', user()->name, ['placeholder' => trans('form.name')]) }}
	</div>

	<div class="form-group simple-group">
		{{ Form::submit(trans('form.save')) }}
	</div>

{!! Form::close() !!}

<h3>@lang('form.change_pwd')</h3>

{!! Form::open(['action' => 'SettingsController@updateUserPassword', 'method' => 'POST', 'class' => 'form']) !!}

	@method('PUT')

	<div class="form-group simple-group">
		{{ Form::label('old_password', trans('form.current_pwd')) }}
		{{ Form::password('old_password', ['placeholder' => trans('form.current_pwd')]) }}
	</div>

	<div class="form-group simple-group">
		{{ Form::label('password', trans('form.new_pwd')) }}
		{{ Form::password('password', ['placeholder' => trans('form.new_pwd')]) }}
	</div>

	<div class="form-group simple-group">
		{{ Form::label('password_confirmation', trans('form.repeat_new_pwd')) }}
		{{ Form::password('password_confirmation', ['placeholder' => trans('form.repeat_new_pwd')]) }}
	</div>

	<div class="form-group simple-group">
		{{ Form::submit(trans('form.save')) }}
	</div>

{!! Form::close() !!}

@endsection