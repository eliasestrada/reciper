<ul class="sidenav" id="mobile-demo">
	@include('includes.nav.menu')

	<li> {{-- Seach trigger --}}
		<a href="#" title="@lang('includes.search')" id="nav-btn-for-search-2">
			@lang('includes.search')
		</a>
	</li>

	<div class="divider"></div>

	@auth 
		{{-- User menu --}}
		<li><ul>@include('includes.nav.user-menu')</ul></li>
	@else
		{{-- Guest menu --}}
		@include('includes.nav.guest-menu')
	@endauth

	<div class="divider"></div>

	@include('includes.nav.categories')
</ul>