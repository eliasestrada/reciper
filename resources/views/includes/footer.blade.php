<footer>
	<div class="row">

		{{--  Navigation  --}}
		<div class="col-12 col-sm-4 text-left">
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
		@isset($footer_rand_recipes)
			@foreach ($footer_rand_recipes->chunk(4) as $random_chunk)
				<div class="col-6 col-sm-4 text-left">
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
		@endisset
	</div>

	<a href="/" title="@lang('includes.home')">
		<img src="{{ asset('favicon.png') }}" alt="@lang('includes.logo')" class="footer-logo">
	</a>

	<p class="footer-copyright">
		&copy; {{ date('Y') }} Delicious Food <br /> {{ $title_footer->text ?? '' }}
	</p>

	@admin
		{{--  Настройки подвала  --}}
		<a class="edit-btn" title="@lang('home.edit_banner')" id="btn-for-footer">
			<i style="background: url('/css/icons/svg/edit-pencil.svg')"></i>
		</a>
		{!! Form::open([
			'action' => 'SettingsController@updateFooterData',
			'method' => 'POST',
			'class' => 'form none',
			'id' => 'footer-form'
		]) !!}
			@method('PUT')
			<div class="form-group">
				{{ Form::textarea('text', $title_footer->text, [
					'placeholder' => trans('settings.footer_text')
				]) }}
				{{ Form::submit(trans('form.save'), ['class' => 'blue']) }}
			</div>
		{!! Form::close() !!}
	@endadmin
</footer>