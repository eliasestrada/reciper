@isset($category_names)
	@foreach ($category_names as $name)
			<li>
				<a href="/search?for={{ str_replace(' ', '-', $name['name_'.lang()]) }}" title="{{ $name['name_'.lang()] }}">
					{{ $name['name_'.lang()] }}
				</a>
			</li>
	@endforeach
@endisset