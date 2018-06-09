<div class="form-group simple-group">
	<label for="meal">@lang('recipes.meal_description')</label>

	<select name="meal" id="meal">
		@foreach ($meal as $m)
			<option value="{{ $m['id'] }}" {{ selectedIfEqual($m['id'], ($meal_id ?? '')) }}>
				{{ title_case($m['name_'.locale()]) }}
			</option>
		@endforeach
	</select>
</div>