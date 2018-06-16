@extends('layouts.app')

@section('title', trans('form.register'))

@section('content')

<div class="container py-5 px-3">
	<form method="POST" action="{{ route('register') }}" class="form">

		@csrf <div class="center-align"><h2 class="headline">@lang('form.register')</h2></div>
	
		<div class="input-field">
			<input type="text" id="name" name="name" value="{{ old('name') }}" class="validate" required>
			<label for="name">@lang('form.name')</label>
			<span class="helper-text">@lang('form.name_desc')</span>
		</div>

		<div class="input-field">
			<input type="email" id="email" name="email" value="{{ old('email') }}" class="validate" required>
			<label for="email">@lang('form.email')</label>
			<span class="helper-text">@lang('form.email_desc')</span>
		</div>

		<div class="input-field">
			<input type="password" id="password" name="password" class="validate" required>
			<label for="password">@lang('form.pwd')</label>
			<span class="helper-text">@lang('form.pwd_desc')</span>
		</div>

		<div class="input-field">
			<input type="password" id="password_confirmation" class="validate" name="password_confirmation" required>
			<label for="password_confirmation">@lang('form.pwd_confirm')</label>
			<span class="helper-text">@lang('form.pwd2_desc')</span>
		</div>

		<blockquote>
			@lang('form.agree_to_terms', ['btn' => trans('form.register'),'terms' => '<a>dsf</a>'])
		</blockquote>

		<!-- Modal Structure -->
		{{-- @TODO: --}}
		<div id="modal1" class="modal">
			<div class="modal-content">
				<h4>Modal Header</h4>
				<p>A bunch of text</p>
			</div>
			<div class="modal-footer">
				<a href="#!" class="modal-close waves-effect waves-green btn-flat left">Agree</a>
			</div>
		</div>
		{{-- -- --}}

		<button type="submit" id="register-btn" class="btn btn-lg btn-main mt-3">
			@lang('form.register')
		</button>
	</form>
</div>

@endsection

@section('script')
	@include('includes.js.modal')
@endsection
