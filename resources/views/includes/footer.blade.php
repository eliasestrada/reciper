<footer class="px-5">
	<div class="row">
		{{--  Navigation  --}}
		<div class="col-12 col-sm-6 col-md-3 text-left">
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
					<a href="/search" class="{{ activeIfRouteIs('search') }}">
						@lang('includes.search')
					</a>
				</li>
			</ul>
		</div>

		{{--  Random recipes  --}}
		@isset($rand_recipes)
			@foreach ($rand_recipes->chunk(10) as $random_chunk)
				<div class="col-12 col-sm-6 col-md-3 text-left">
					<ul class="unstyled-list">
						<li><strong>@lang('includes.recipes')</strong></li>
						@foreach ($random_chunk as $recipe)
							<li>
								<a href="/recipes/{{ $recipe->id }}" title="{{ $recipe->title }}">
									{{ $recipe->title }}
								</a>
							</li>
						@endforeach
					</ul>
				</div>
			@endforeach
		@endisset

		{{--  Popular recipes  --}}
		<div class="col-12 col-sm-6 col-md-3 text-left">
			<ul class="unstyled-list">
				@isset($popular_recipes)
					<li><strong>@lang('includes.popular_recipes')</strong></li>
					@foreach ($popular_recipes as $recipe)
						<li>
							<a href="/recipes/{{ $recipe->id }}" title="{{ $recipe->title }}">
								{{ $recipe->title }}
							</a>
						</li>
					@endforeach
				@endisset
			<ul>
		</div>
	</div>

	<a href="/" title="@lang('includes.home')">
		<img src="{{ asset('favicon.png') }}" alt="@lang('includes.logo')" class="footer-logo">
	</a>

	<p class="footer-copyright">
		&copy; {{ date('Y') }} Delicious Food <br /> {{ $title_footer ?? '' }}
	</p>

	@admin
		{{--  Настройки подвала  --}}
		<div style="position:relative;">
			<a class="edit-btn" title="@lang('home.edit_banner')" id="btn-for-footer">
				<i style="background: url('/css/icons/svg/edit-pencil.svg')"></i>
			</a>
			@component('components.edit_form')
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
					@lang('settings.footer_text')
				@endslot
			@endcomponent
		</div>
	@endadmin
</footer>