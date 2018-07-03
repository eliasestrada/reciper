<footer class="px-5 pt-3 pb-5">
	<div class="row wrapper">
		{{--  Navigation  --}}
		<div class="col s12 m6 l3 left-align">
			<ul class="unstyled-list">
				<li><strong>@lang('includes.navigation')</strong></li>
				<li>
					<a href="/" class="{{ activeIfRouteIs('/') }}">
						@lang('includes.home')
					</a>
				</li>
				<li>
					<a href="/recipes" class="{{ activeIfRouteIs('recipes') }}">
						@lang('includes.recipes')
					</a>
				</li>
				<li>
					<a href="/contact" class="{{ activeIfRouteIs('contact') }}">
						@lang('includes.feedback')
					</a>
				</li>
				<li>
					<a href="#" id="nav-btn-for-search-3">
						@lang('includes.search')
					</a>
				</li>
			</ul>
		</div>

		{{--  Random recipes  --}}
		@isset($rand_recipes)
			@foreach ($rand_recipes->chunk(10) as $random_chunk)
				<div class="col s12 m6 l3 left-align">
					<ul class="unstyled-list">
						<li><strong>@lang('includes.recipes')</strong></li>
						@foreach ($random_chunk as $recipe)
							<li>
								<a href="/recipes/{{ $recipe->id }}" title="{{ $recipe->getTitle() }}">
									{{ $recipe->getTitle() }}
								</a>
							</li>
						@endforeach
					</ul>
				</div>
			@endforeach
		@endisset

		{{--  Popular recipes  --}}
		<div class="col s12 m6 l3 left-align">
			<ul class="unstyled-list">
				@isset($popular_recipes)
					<li><strong>@lang('includes.popular_recipes')</strong></li>
					@foreach ($popular_recipes as $recipe)
						<li>
							<a href="/recipes/{{ $recipe->id }}" title="{{ $recipe->getTitle() }}">
								{{ $recipe->getTitle() }}
							</a>
						</li>
					@endforeach
				@endisset
			<ul>
		</div>
	</div>

	<div class="center">
		<a href="/" title="@lang('includes.home')">
			<img src="{{ asset('favicon.png') }}" alt="@lang('includes.logo')" class="footer-logo">
		</a>
	
		<p class="footer-copyright">
			&copy; {{ date('Y') }} Delicious Food <br /> {{ $title_footer ?? '' }}
		</p>
	</div>

	@admin
		{{--  Настройки подвала  --}}
		<div class="position-relative">
			<a class="edit-btn" title="@lang('home.edit_banner')" id="btn-for-footer">
				<i class="material-icons">edit</i>
			</a>
			@editForm
				@slot('id')
					footer-form
				@endslot
				@slot('text')
					{{ $title_footer }}
				@endslot
				@slot('action')
					SettingsController@updateFooterData
				@endslot
				@slot('holder_text')
					@lang('home.footer_text')
				@endslot
				@slot('slug_text')
					footer_text
				@endslot
			@endeditForm
		</div>
	@endadmin
</footer>