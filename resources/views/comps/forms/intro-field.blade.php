<div class="input-field">
	<textarea name="intro" id="intro" class="materialize-textarea counter" data-length="{{ config('validation.recipe_intro_max') }}">{{ ($intro ?? '') }}</textarea>

	<label for="intro">
		@lang('recipes.short_intro') 
		@include('includes.tip', ['tip' => trans('recipes.text_description')])
	</label>
</div>