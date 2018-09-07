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
					<li style="border-left-color:#{{ $recipe->isDone() ? '65b56e' : 'ce7777' }};" class="col s12 m6 l4 row">
						<a href="/recipes/{{ $recipe->id }}" style="width:11em">
							<img src="{{ asset('storage/images/small/'.$recipe->image) }}" alt="{{ $recipe->getTitle() }}" />
						</a>
	
						<div class="item-content">
							<section>{{ str_limit($recipe->getTitle(), 45) }}</section>
							<section>{{ timeAgo($recipe->updated_at) }}</section>
						</div>

						<div class="mt-3" style="width:35px">
							<span class="new badge tooltipped {{ $recipe->isDone() ? 'green' : 'red' }}" style="min-width:auto; height:28px; padding:3px;" data-tooltip="@lang('users.status'): {{ $recipe->getStatus() }}">
							<i class="material-icons" style="font-size:23px">{{ $recipe->getStatus('icon') }}</i>
							</span>
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
	</div>

	@isset($recipes)
		{{ optional($recipes)->links() }}
	@endisset
</div>