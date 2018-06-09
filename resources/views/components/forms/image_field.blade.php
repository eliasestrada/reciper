<div class="form-group simple-group text-center pb-5" style="border-bottom:solid 1px lightgray;">
	<h3 class="col-12 text-center mb-2">@lang('recipes.image')</h3>

	<label for="src-image" class="image-label mt-3" title="{{ trans('recipes.select_file') }}">
		@lang('recipes.select_file')
	</label>

	<input type="file" name="image" id="src-image" class="d-none">

	<section class="preview-image">
		<img src="{{ asset('storage/images/'.$image) }}" alt="{{ $alt }}" id="target-image">
	</section>
</div>