<div class="home-edit-form" id="{{ $id }}">
	<form action="{{ action($action) }}" method="post" class="form">

		@method('put')
		@csrf

		<div class="form-group">
			@if (isset($title) && isset($holder_title))
				<input type="text" value="{{ $title }}" placeholder="{{ $holder_title }}">
			@endif
			@if (isset($text) && isset($holder_text))
				<textarea name="text" placeholder="{{ $holder_text }}">{{ $text }}</textarea>
			@endif
			<button type="submit" class="btn btn-main btn-lg">@lang('form.save')</button>
		</div>

	</form>
</div>