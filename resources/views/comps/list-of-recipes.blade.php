<div class="page">
	@isset($title)
		<div class="center">
			<h1 class="headline">
				{{ $title }}{{ count($recipes) > 0 ? ': '.count($recipes) : '' }}
			</h1>
		</div>
	@endisset

	<div class="item-list unstyled-list row">
		@isset($recipes)
			@forelse ($recipes as $recipe)
				<ul>
					<li style="border-left-color:#{{ $recipe->done() ? '65b56e' : 'ce7777' }};" class="col s12 m6 l4">
						<a href="/recipes/{{ $recipe->id }}">
							<img src="{{ asset('storage/images/small/'.$recipe->image) }}" alt="{{ $recipe->getTitle() }}" />
						</a>
	
						<div class="item-content">
							<section>{{ str_limit($recipe->getTitle(), 45) }}</section>
							<section>
								@lang('users.date') {{ timeAgo($recipe->updated_at) }}
							</section>
							<section>
								<span class="new badge mt-3 tooltipped {{ $recipe->done() ? 'green' : 'red' }}" style="min-width:auto" data-tooltip="@lang('users.status'): {{ $recipe->getStatus() }}">
									<i class="material-icons" style="font-size:21px">{{ $recipe->getStatus('icon') }}</i>
								</span>
							</section>
						</div>
					</li>
				</ul>
			@empty
				@isset($no_recipes)
					@component('comps.empty')
						@slot('text')
							{{ $no_recipes }}
						@endslot
					@endcomponent
				@endisset
			@endforelse
		@endisset

		@isset($recipes)
			{{ optional($recipes)->links() }}
		@endisset
	</div>
</div>