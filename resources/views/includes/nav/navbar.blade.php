 <!-- Categories Dropdown menu -->
 <ul id="dropdown1" class="dropdown-content bottom-borders">
	@include('includes.nav.categories')
</ul>

@auth <!-- User Dropdown menu -->
	<ul id="dropdown2" class="dropdown-content bottom-borders">
		@include('includes.nav.user-menu')
	</ul>
@endauth

<nav>
	<div class="nav-wrapper main" style="z-index:15">
		<div class="px-3">
			<a href="/" title="@lang('includes.home')" class="brand-logo">{{ config('app.name') }}</a>
			<a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>

			<ul class="right hide-on-med-and-down right-borders">
				@include('includes.nav.menu')

				<li> <!-- Dropdown Trigger 1 Categories -->
					<a class="dropdown-trigger" href="#!" data-target="dropdown1">
						@lang('includes.categories')
						<i class="material-icons right">arrow_drop_down</i>
					</a>
				</li>
				@auth
					<li> <!-- Dropdown Trigger 2 User -->
						<a class="dropdown-trigger" id="_user-menu" href="#!" data-target="dropdown2">
							@lang('includes.profile')
							<i class="right user-icon">
								<img src="{{ asset('storage/users/' . user()->image) }}" alt="user">
							</i>
						</a>
					</li>
				@else
					{{-- @TODO: --}}
				@endauth
				@include('includes.nav.search-form')
			</ul>
		</div>
	</div>
</nav>

<ul class="sidenav" id="mobile-demo">
	@include('includes.nav.menu')

	<li> <!-- Categories -->
		<ul class="collapsible">
			<li>
				<div class="collapsible-header">
					<i class="material-icons">arrow_drop_down</i>
					<span>@lang('includes.categories')</span>
				</div>
				<div class="collapsible-body"><ul>@include('includes.nav.categories')</ul></div>
			</li>
		</ul>
	</li>

	@auth <!-- User Menu -->
		<div class="divider"></div>
		<li><ul>@include('includes.nav.user-menu')</ul></li>
	@endauth
</ul>


{{-- {{ request()->is('/') ? 'style="position:absolute;"' : '' }} --}}