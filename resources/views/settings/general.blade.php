@extends('layouts.app')

@section('title', trans('settings.general'))

@section('content')

<div class="row">
	<div class="col-md-6">
		<form action="{{ action('SettingsController@updateUserPassword') }}" method="post" class="form">

			@method('put')
			@csrf
		
			<div class="form-group simple-group">
				<h2 class="form-headline">
					<i class="title-icon" style="background: url('/css/icons/svg/question.svg')"></i>
					@lang('form.change_pwd')
				</h2>
				
				<label for="old_password">@lang('form.current_pwd')</label>
				<input type="password" name="old_password" id="old_password" placeholder="@lang('form.current_pwd')">
			</div>
		
			<div class="form-group simple-group">
				<label for="password">@lang('form.new_pwd')</label>
				<input type="password" name="password" id="password" placeholder="@lang('form.new_pwd')">
			</div>
		
			<div class="form-group simple-group">
				<label for="password_confirmation">@lang('form.repeat_new_pwd')</label>
				<input type="password" name="password_confirmation" id="password_confirmation" placeholder="@lang('form.repeat_new_pwd')">
			</div>

			<div class="form-group simple-group mt-4">
				<button class="btn" type="submit">@lang('form.save_changes')</button>
			</div>
		
		</form>
	</div>
	<div class="col-md-6">
		<form action="{{ action('SettingsController@updateUserData') }}" method="post" class="form">

			@csrf
			@method('put')
		
			<div class="form-group simple-group">
				<h2 class="form-headline">
					<i class="title-icon" style="background: url('/css/icons/svg/wrench.svg')"></i>
					@lang('settings.general')
				</h2>
		
				<label for="name">@lang('form.name')</label>
				<input type="text" value="{{ user()->name }}" placeholder="@lang('form.name')">
			</div>

			<div class="form-group simple-group mt-4">
				<button class="btn" type="submit">@lang('form.save_changes')</button>
			</div>

		</form>
	</div>
</div>

@endsection