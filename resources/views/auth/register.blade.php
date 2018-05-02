@extends('layouts.app')

@section('title', trans('form.register'))

@section('content')

<form method="POST" action="{{ route('register') }}" class="form">
	@csrf

	<div class="form-group simple-group">
		<h2 class="form-headline">
			<i class="title-icon" style="background: url('/css/icons/svg/user-add.svg')"></i>
			@lang('form.register')
		</h2>

		<label for="name">@lang('form.this_name_will_be_on_every_recipe')</label>
		<input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="@lang('form.name')" required autofocus>

		<label for="email">@lang('form.email')</label>
		<input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="@lang('form.email')" required>

		<label for="password">@lang('form.pwd')</label>
		<input type="password" id="password" name="password" placeholder="@lang('form.pwd')" required>

		<label for="password_confirmation">@lang('form.pwd_confirm')</label>
		<input type="password" id="password_confirmation" name="password_confirmation" placeholder="@lang('form.pwd_confirm')" required>

		<input type="submit" value="@lang('form.register')">
	</div>
</form>
<div class="spacer"></div>

@endsection
