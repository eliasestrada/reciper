{{-- Categories Dropdown menu --}}
<ul id="dropdown1" class="dropdown-content bottom-borders">
	@include('includes.nav.categories')
</ul>

@auth {{-- User Dropdown menu --}}
	<ul id="dropdown2" class="dropdown-content bottom-borders">
		@include('includes.nav.user-menu')
	</ul>
@endauth

<nav>
	<div class="nav-wrapper main" style="z-index:15">
		<div class="px-3">
			{{-- Logo --}}
			<a href="/" title="@lang('includes.home')" class="brand-logo">
				{{ config('app.name') }}
			</a>
			{{-- Hamburger menu --}}
			<a href="#" data-target="mobile-demo" class="sidenav-trigger">
				<i class="material-icons">menu</i>
			</a>

			<ul class="right hide-on-med-and-down right-borders">
				@include('includes.nav.menu')
				{{-- Seach trigger --}}
				<li> {{-- Dropdown Trigger 1 Categories --}}
					<a class="dropdown-trigger" href="#!" data-target="dropdown1">
						@lang('includes.categories')
						<i class="material-icons right">arrow_drop_down</i>
					</a>
				</li>
				<li>
					<a href="#" title="@lang('includes.search')" id="nav-btn-for-search-1">
						<i class="material-icons">search</i>
					</a>
				</li>
				@auth
					<li> {{-- Dropdown Trigger 2 User --}}
						<a id="_user-menu-trigger" class="dropdown-trigger" href="#!" data-target="dropdown2" title="@lang('includes.profile')">
							<i class="right user-icon">
								<img class="user-icon-big" src="{{ asset('storage/users/' . user()->image) }}" alt="user">
							</i>
						</a>
					</li>
				@else
					{{-- Guest menu --}}
					@include('includes.nav.guest-menu')
				@endauth
			</ul>
		</div>
	</div>
</nav>

{{-- Search navigation --}}
<nav class="main-hover nav-search-form" id="nav-search-form">
	<div class="nav-wrapper container">
		<form action="{{ action('PagesController@search') }}" method="get">
			<div class="input-field">
				<input id="search-input" type="search" name="for" placeholder="@lang('pages.search_details')" required>
				<label class="label-icon" for="search-input">
					<i class="material-icons">search</i>
				</label>
				<i class="material-icons">close</i>
			</div>
		</form>
	</div>
</nav>

{{-- @TODO: --}}
{{-- {{ request()->is('/') ? 'style="position:absolute;"' : '' }} --}}