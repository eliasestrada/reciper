<div class="page">
	@isset($title)
		<div class="center-align">
			<h1 class="headline">
				{{ $title }}{{ count($recipes) > 0 ? ': '.count($recipes) : '' }}
			</h1>
		</div>
	@endisset

	<div class="item-list unstyled-list row">
		@isset($recipes)
			@forelse ($recipes as $recipe)
				<a href="/recipes/{{ $recipe->id }}" title="{{ $recipe->getTitle() }}" class="col s12 m6 l4">
					<li style="border-left-color:#{{ $recipe->done() ? '65b56e' : 'ce7777' }};">
						<img src="{{ asset('storage/images/'.$recipe->image) }}" alt="{{ $recipe->getTitle() }}" />

						<div class="item-content">
							<section>{{ $recipe->getTitle() }}</section>
							<section>
								@lang('users.date') {{ facebookTimeAgo($recipe->updated_at) }}
							</section>
							<section>
								<span class="new badge mt-2 {{ $recipe->done() ? 'green' : 'red' }}">
									@lang('users.status'): {{ $recipe->getStatus() }}
								</span>
							</section>
						</div>
					</li>
				</a>
			@empty
				@isset($no_recipes)
					<div class="center-align">
						<p class="flow-text grey-text">{{ $no_recipes }}</p>
					</div>
				@endisset
			@endforelse
		@endisset

		@isset($recipes)
			{{ optional($recipes)->links() }}
		@endisset
	</div>
</div>