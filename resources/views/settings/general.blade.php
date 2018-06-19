@extends('layouts.app')

@section('title', trans('settings.general'))

@section('content')

<div class="row page">
	<div class="col s12 m6 mb-5">
		<div class="center-align">
			<h2 class="headline">@lang('form.change_pwd')</h2>
		</div>

		<form action="{{ action('SettingsController@updateUserPassword') }}" method="post">
			@method('put') @csrf
		
			<div class="input-field">
				<label for="old_password">@lang('form.current_pwd')</label>
				<input type="password" name="old_password" id="old_password" placeholder="@lang('form.current_pwd')">
			</div>
		
			<div class="input-field">
				<label for="password">@lang('form.new_pwd')</label>
				<input type="password" name="password" id="password" placeholder="@lang('form.new_pwd')">
			</div>
		
			<div class="input-field">
				<label for="password_confirmation">@lang('form.repeat_new_pwd')</label>
				<input type="password" name="password_confirmation" id="password_confirmation" placeholder="@lang('form.repeat_new_pwd')">
			</div>

			<div class="input-field mt-4 center-align">
				<button class="btn" type="submit">@lang('form.save_changes')</button>
			</div>
		</form>
	</div>

	<div class="col s12 m6">
		<div class="center-align">
			<h2 class="headline">@lang('settings.general')</h2>
		</div>
		<form action="{{ action('SettingsController@updateUserData') }}" method="post" class="form">
			@csrf
			@method('put')
		
			<div class="input-field">
				<label for="name">@lang('form.name')</label>
				<input type="text" value="{{ user()->name }}" placeholder="@lang('form.name')">
			</div>

			<div class="input-field mt-4 center-align">
				<button class="btn" type="submit">@lang('form.save_changes')</button>
			</div>

		</form>
	</div>
</div>

@endsection