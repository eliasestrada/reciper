<div class="home-edit-form" id="{{ $id }}">
	{!! Form::open(['action' => $action, 'method' => 'PUT', 'class' => 'form']) !!}

		<div class="form-group">
			@if (isset($title) && isset($holder_title))
				{{ Form::text('title', $title, ['placeholder' => $holder_title]) }}
			@endif
			@if (isset($text) && isset($holder_text))
				{{ Form::textarea('text', $text, ['placeholder' => $holder_text]) }}
			@endif
			<button type="submit" class="btn btn-main btn-lg">@lang('form.save')</button>
		</div>

	{!! Form::close() !!}
</div>