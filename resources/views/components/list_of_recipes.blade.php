@author
	<div>
		@isset($title)
			<h1 class="headline">{{ $title }}</h1>
		@endisset

		<div class="item-list unstyled-list row">
			@isset($recipes)

				
				@forelse ($recipes->toArray()['data'] as $recipe)
					<a href="/recipes/{{ $recipe['id'] }}" title="{{ $recipe['title_'.locale()] }}" class="col-lg-6">
						<li style="border-left:solid 3px #{{ $recipe['approved_'.locale()] === 1 ? '65b56e' : 'ce7777' }};">
							<img src="{{ asset('storage/images/'.$recipe['image']) }}" alt="{{ $recipe['title_'.locale()] }}" />
							<div class="item-content">
								<h3 class="project-name">{{ $recipe['title_'.locale()] }}</h3>
								<p class="project-title">
									@lang('users.status'): {{ $recipe['approved_'.locale()] === 1 ? trans('users.checked') : trans('users.not_checked') }}
								</p>
								<p class="project-title">
									@lang('users.date') {{ facebookTimeAgo($recipe['updated_at']) }}
								</p>
							</div>
						</li>
					</a>
				@empty
					@isset($no_recipes)
						<p class="col-12 text-center">{{ $no_recipes }}</p>
					@endisset
				@endforelse

			@endisset
	
			@isset($recipes)
				{{ optional($recipes)->links() }}
			@endisset
		</div>
	</div>
@endauthor