@isset($category_names)
	@foreach ($category_names as $name)
			<li>
				<a href="/search?for={{ str_replace(' ', '-', $name['name_'.locale()]) }}" title="{{ $name['name_'.locale()] }}">
					{{ $name['name_'.locale()] }}
				</a>
			</li>
	@endforeach
@endisset