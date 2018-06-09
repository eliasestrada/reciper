<div class="form-group">
	<label for="ingredients">@lang('recipes.ingredients')</label>
	<textarea name="ingredients" id="ingredients" placeholder="@lang('recipes.ingredients_description')">{{ ($ingredients ?? '') }}</textarea>
</div>