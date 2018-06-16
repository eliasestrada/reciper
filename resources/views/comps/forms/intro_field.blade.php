<div class="input-field">
	<textarea name="intro" id="intro" class="materialize-textarea counter" data-length="{{ config('validation.intro_max') }}">{{ ($intro ?? '') }}</textarea>
	<label for="intro">@lang('recipes.intro')</label>

	<span class="helper-text">@lang('recipes.short_intro')</span>
</div>