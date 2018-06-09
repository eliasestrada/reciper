<div class="form-group">
	<label for="text">@lang('recipes.text_of_recipe')</label>
	<textarea name="text" id="text" placeholder="@lang('recipes.text_description')">{{ $text ?? '' }}</textarea>
</div>