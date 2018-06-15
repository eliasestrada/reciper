<div>
	@isset($title)
		<h1 class="headline">
			{{ $title }}{{ count($recipes) > 0 ? ': '.count($recipes) : '' }}
		</h1>
	@endisset

	<div class="item-list unstyled-list row">
		@isset($recipes)

			@forelse ($recipes as $recipe)
				<a href="/recipes/{{ $recipe->id }}" title="{{ $recipe->getTitle() }}" class="col l6">
					<li style="border-left:solid 3px #{{ $recipe->approved() && $recipe->ready() ? '65b56e' : 'ce7777' }};">
						<img src="{{ asset('storage/images/'.$recipe->image) }}" alt="{{ $recipe->getTitle() }}" />

						<div class="item-content">
							<h3 class="project-name">{{ $recipe->getTitle() }}</h3>
							<p class="project-title">
								@lang('users.status'): {{ $recipe->getStatus() }}
							</p>
							<p class="project-title">
								@lang('users.date') {{ facebookTimeAgo($recipe->updated_at) }}
							</p>
						</div>
					</li>
				</a>
			@empty
				@isset($no_recipes)
					<p class="col s12 text-center">{{ $no_recipes }}</p>
				@endisset
			@endforelse

		@endisset

		@isset($recipes)
			{{ optional($recipes)->links() }}
		@endisset
	</div>
</div>