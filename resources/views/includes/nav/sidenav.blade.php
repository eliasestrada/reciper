<ul class="sidenav" id="mobile-demo">
	@include('includes.nav.menu')

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