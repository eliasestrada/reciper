<div class="form-group simple-group center-align pb-5" style="border-bottom:solid 1px lightgray;">
	<h3 class="col s12 center-align mb-2">@lang('recipes.image')</h3>

	<label for="src-image" class="image-label mt-3" title="{{ trans('recipes.select_file') }}">
		@lang('recipes.select_file')
	</label>

	<input type="file" name="image" id="src-image" class="d-none">

	<section class="preview-image">
		<img 
			src="{{ asset('storage/images/' . ($image ?? 'default.jpg')) }}" 
			alt="{{ ($alt ?? trans('recipes.image')) }}" 
			id="target-image"
		>
	</section>
</div>