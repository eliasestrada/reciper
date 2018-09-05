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
			<a href="/" title="@lang('includes.home')" class="brand-logo noselect">
				@lang('website.name')
			</a>
			{{-- Hamburger menu --}}
			<a href="#" data-target="mobile-demo" class="sidenav-trigger noselect">
				<i class="material-icons">menu</i>
			</a>

			<ul class="right hide-on-med-and-down right-borders">
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

				<li> {{-- Dropdown Trigger 1 Categories --}}
					<a class="dropdown-trigger" href="#!" data-target="dropdown1">
						@lang('includes.categories')
						<i class="material-icons right">arrow_drop_down</i>
					</a>
				</li>

				@php
					$all_notif = array_sum([
						$all_unapproved, $all_feedback, $notifications, $all_logs
					]);
				@endphp

				@auth
					<li> {{-- Dropdown Trigger 2 User --}}
						<a id="_user-menu-trigger" class="dropdown-trigger small-notif-btn position-relative" href="#!" data-target="dropdown2" title="@lang('includes.user_home')" {{ $all_notif ? 'data-notif='.$all_notif : '' }}>
							<i class="right user-icon">
								<img class="user-icon-big" src="{{ asset('storage/users/' . user()->image) }}">
							</i>
						</a>
					</li>
				@else
					<li> {{-- Guest menu --}}
						<a href="/login" data-target="dropdown3" title="@lang('includes.enter')">
							@lang('includes.enter')
							<i class="material-icons right">exit_to_app</i>
						</a>
					</li>
				@endauth
			</ul>
					
			{{-- Search button --}}
			<a href="#" data-target="mobile-demo" class="right px-4" title="@lang('includes.search')" id="nav-btn-for-search">
				<i class="material-icons">search</i>
			</a>
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