@extends('layouts.error')

@section('title', $title)

@section('content')

	<div class="d-flex" style="height:100vh; align-items:center; justify-content:center; flex-direction:column">
		<h2 class="mb-3">{{ $error }}</h2>
		<h2 class="mb-3">{{ $title }}</h2>
		<p class="mb-3">{{ $slot }}</p>
		@if (! isset($btn))
			<a href="/" class="btn" title="@lang('errors.to_home')">
				@lang('errors.to_home')
			</a>
		@endif
	</div>

@endsection