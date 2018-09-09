<div class="item-list unstyled-list row {{ ($class ?? '') }}" {{ isset($id) ? 'id=' . $id : '' }}>
	@isset($recipes)
		@forelse ($recipes as $recipe)
			<ul>
				<li style="border-left-color:{{ $recipe->getStatusColor() }};" class="col s12 m6 l4 row">
					<a href="/recipes/{{ $recipe->id }}" style="width:11em">
						<img src="{{ asset('storage/images/small/'.$recipe->image) }}" alt="{{ $recipe->getTitle() }}" />
					</a>

					<div class="item-content">
						<section>{{ str_limit($recipe->getTitle(), 45) }}</section>
						<section>{{ time_ago($recipe->updated_at) }}</section>
					</div>

					<div class="mt-3" style="width:35px">
						<span class="new badge tooltipped" style="min-width:auto; height:28px; padding:3px; background-color:{{ $recipe->getStatusColor() }}" data-tooltip="@lang('users.status'): {{ $recipe->getStatusText() }}">
							<i class="material-icons" style="font-size:23px">{{ $recipe->getStatusIcon() }}</i>
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