<footer>
	<div class="container">
		<div class="row">

			{{--  Random recipes  --}}
			@foreach ($footer_rand_recipes->chunk(4) as $random_chunk)
				<div class="col-xs-6 col-sm-4">
					<ul class="unstyled-list">
						<li><strong>@lang('includes.recipes')</strong></li>
						@foreach ($random_chunk as $footer_recipe)
							<li>
								<a href="/recipes/{{ $footer_recipe->id }}" title="{{ $footer_recipe->title }}">
									{{ $footer_recipe->title }}
								</a>
							</li>
						@endforeach
					</ul>
				</div>
			@endforeach

			{{--  Navigation  --}}
			<div class="col-xs-12 col-sm-4">
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
		</div>

		<a href="/" title="@lang('includes.home')">
			<img src="{{ asset('favicon.png') }}" alt="@lang('includes.logo')" class="footer-logo">
		</a>

		<p class="footer-copyright">
			&copy; {{ date('Y') }} Delicious Food {{ optional($title_footer)->text }}
		</p>

		<p class="footer-copyright">
			@lang('includes.my_rights')
		</p>
	</div>
</footer>