@extends('layouts.app')

@section('title', trans('settings.general'))

@section('content')

<div class="row page">
	<div class="col s12 m6 mb-5">
		<div class="center">
			<h2 class="headline">@lang('form.change_pwd')</h2>
		</div>

		<form action="{{ action('SettingsController@updateUserPassword') }}" method="post">
			<div class="input-field"> @method('put') @csrf
				<label for="old_password">@lang('form.current_pwd')</label>
				<input type="password" name="old_password" id="old_password">
			</div>
		
			<div class="input-field">
				<label for="password">@lang('form.new_pwd')</label>
				<input type="password" name="password" id="password">
			</div>
		
			<div class="input-field">
				<label for="password_confirmation">@lang('form.repeat_new_pwd')</label>
				<input type="password" name="password_confirmation" id="password_confirmation">
			</div>

			<div class="input-field mt-4 center">
				<button class="btn" type="submit">@lang('form.save_changes')</button>
			</div>
		</form>
	</div>

	<div class="col s12 m6">
		<div class="center">
			<h2 class="headline">@lang('settings.general')</h2>
		</div>

		<form action="{{ action('SettingsController@updateUserData') }}" method="post" class="form">
			<div class="input-field"> @csrf @method('put')
				<label for="name">@lang('form.name')</label>
				<input type="text" name="name" id="name" value="{{ user()->name }}">
			</div>

			<div class="input-field mt-4 center">
				<button class="btn" type="submit">@lang('form.save_changes')</button>
			</div>
		</form>
	</div>
</div>

@endsection