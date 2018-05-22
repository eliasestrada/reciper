@author
	<div class="container">
		@isset($title, $recipes)
			<h2 class="content center">
				{{ count($recipes) > 0 ? $title .' '. count($recipes) : '' }}
			</h2>
		@endisset

		<div class="item-list unstyled-list row">
			@isset($recipes)
				@forelse ($recipes as $recipe)
					<a href="/recipes/{{ $recipe->id }}" title="{{ $recipe->title }}" class="col-lg-6">
						<li style="border-left:solid 3px #{{ $recipe->approved() ? '65b56e' : 'ce7777' }};">
							<img src="{{ asset('storage/images/'.$recipe->image) }}" alt="{{ $recipe->title }}" />
							<div class="item-content">
								<h3 class="project-name">{{ $recipe->title }}</h3>
								<p class="project-title">
									@lang('users.status'): {{ $recipe->approved() ? trans('users.checked') : trans('users.not_checked') }}
								</p>
								<p class="project-title">
									@lang('users.date') {{ facebookTimeAgo($recipe->updated_at) }}
								</p>
							</div>
						</li>
					</a>
				@empty
					@isset($no_recipes)
						<p class="content center">{{ $no_recipes }}</p>
					@endisset
				@endforelse
			@endisset
	
			@isset($recipes)
				{{ optional($recipes)->links() }}
			@endisset
		</div>
	</div>
@endauthor