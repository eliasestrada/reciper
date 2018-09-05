<ul class="sidenav" id="mobile-demo">
	<li class="{{ active_if_route_is('/') }}">
		<a href="/" title="@lang('includes.home')">
			@lang('includes.home')
		</a>
	</li>
	<li class="{{ active_if_route_is('recipes') }}">
		<a href="/recipes" title="@lang('includes.recipes')">
			@lang('includes.recipes')
		</a>
	</li>

	<div class="divider"></div>

	@auth 
		{{-- User menu --}}
		<li><ul>@include('includes.nav.user-menu')</ul></li>
	@else
		{{-- Guest menu --}}
		<li>
			<a href="/login" data-target="dropdown3" title="@lang('includes.enter')">
				@lang('includes.enter')
				<i class="material-icons right">exit_to_app</i>
			</a>
		</li>
	@endauth

	<div class="divider"></div>

	@include('includes.nav.categories')
</ul>