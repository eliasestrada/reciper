<div class="input-field">
	<select name="meal" id="meal">
		@foreach ($meal as $m)
			<option value="{{ $m['id'] }}" {{ selectedIfEqual($m['id'], ($meal_id ?? '')) }}>
				{{ title_case($m['name_'.locale()]) }}
			</option>
		@endforeach
		<label>Materialize Select</label>
	</select>
	<label for="meal">@lang('recipes.meal_description')</label>
</div>