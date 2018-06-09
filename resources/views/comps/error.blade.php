@extends('layouts.error')

@section('title', $title)

@section('content')

	<div class="d-flex pb-5" style="height:100vh; align-items:center; justify-content:center; flex-direction:column">
		<h2 class="mb-3 headline">{{ $error }}</h2>
		<h2 class="mb-3 content">{{ $title }}</h2>
		<p class="mb-3">{{ $slot }}</p>
		@if (! isset($btn))
			<a href="/" class="btn" title="@lang('errors.to_home')">
				@lang('errors.to_home')
			</a>
		@endif
	</div>

@endsection