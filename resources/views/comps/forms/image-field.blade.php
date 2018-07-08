<div class="center pb-5">
	<h5 class="col s12 mb-2">@lang('recipes.image')</h5>

	<div class="file-field input-field">
		<div class="btn">
			<span>@lang('recipes.select_file')</span>
			<input type="file" name="image" id="src-image" style="overflow:hidden">
		</div>
		<div class="file-path-wrapper">
			<input class="file-path validate" type="text">
		</div>
	</div>

	<section class="preview-image">
		<img src="{{ asset('storage/images/' . ($image ?? 'default.jpg')) }}" alt="{{ ($alt ?? trans('recipes.image')) }}" id="target-image">
	</section>
</div>