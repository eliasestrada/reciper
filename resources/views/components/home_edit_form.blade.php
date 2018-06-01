<div class="home-edit-form" id="{{ $id }}">
	{!! Form::open([
		'action' => $action,
		'method' => 'PUT',
		'class' => 'form'
	]) !!}

		<div class="form-group">
			@isset($holder_title)
				{{ Form::text('title', $array->title, ['placeholder' => $holder_title]) }}
			@endisset
			@isset($holder_text)
				{{ Form::textarea('text', $array->text, ['placeholder' => $holder_text]) }}
			@endisset
			{{ Form::submit(trans('form.save'), ['class' => 'btn btn-main btn-lg']) }}
		</div>

	{!! Form::close() !!}
</div>