@extends('layouts.app')

@section('title', trans('pages.feedback'))

@section('content')

<h1 class="headline">@lang('pages.feedback')</h1>

<form action="{{ action('ContactController@store') }}" method="post" class="form">
	<div class="form-group simple-group">
		<label for="email">@lang('form.email')</label>
		<input type="email" name="email" placeholder="@lang('form.email')">
	</div>
	<div class="form-group simple-group">
		<label for="message">@lang('form.message')</label>
		<textarea name="message" placeholder="@lang('form.message')"></textarea>
	</div>
	<div class="form-group simple-group">
		<button type="submit" class="btn btn-main">@lang('form.send')</button>
	</div>
</form>

@endsection