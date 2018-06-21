<div class="input-field">
	<input type="text" name="title" id="title" value="{{ ($title ?? '') }}" class="counter" data-length="{{ config('validation.title_max') }}">
	<label for="title">@lang('recipes.title')</label>
</div>