<div class="input-field">
	<textarea name="ingredients" id="ingredients" class="materialize-textarea counter" data-length="{{ config('validation.ingredients_max') }}">{{ ($ingredients ?? '') }}</textarea>

	<label for="ingredients">
		@lang('recipes.ingredients') 
		@include('includes.tip', ['tip' => trans('recipes.ingredients_desc')])
	</label>
</div>