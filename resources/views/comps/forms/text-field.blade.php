<div class="input-field">
	<textarea name="text" id="text" class="materialize-textarea counter" data-length="{{ config('validation.text_max') }}">{{ ($text ?? '') }}</textarea>

	<label for="text">
		@lang('recipes.text_of_recipe') 
		@include('includes.tip', ['tip' => trans('recipes.text_description')])
	</label>
</div>