<label for="meal">@lang('recipes.meal_description')</label>
<select name="meal" id="meal" class="browser-default">
	@foreach ($meal as $m)
		<option value="{{ $m['id'] }}" {{ selectedIfEqual($m['id'], ($meal_id ?? '')) }}>
			{{ title_case($m['name_'.locale()]) }}
		</option>
	@endforeach
</select>