<div class="input-field">
	<textarea name="ingredients" id="ingredients" class="materialize-textarea counter" data-length="{{ config('validation.ingredients_max') }}">{{ ($intro ?? '') }}</textarea>
	<label for="ingredients">@lang('recipes.ingredients')</label>

	<span class="helper-text">@lang('recipes.ingredients_desc')</span>
</div>