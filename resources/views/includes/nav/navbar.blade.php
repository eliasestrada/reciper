 <!-- Categories -->
<ul id="dropdown1" class="dropdown-content">
	@include('includes.nav.categories')
</ul>

<nav>
	<div class="nav-wrapper main">
		<div class="wrapper">
			<a href="/" title="@lang('includes.home')" class="brand-logo">
				{{ config('app.name') }}
			</a>
			<a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>

			<ul class="right hide-on-med-and-down">
				@include('includes.nav.menu')

				<li> <!-- Dropdown Trigger -->
					<a class="dropdown-trigger" href="#!" data-target="dropdown1">
						@lang('includes.categories')
						<i class="material-icons right">arrow_drop_down</i>
					</a>
				</li>
				<li>
					<form action="{{ action('PagesController@search') }}" method="get">
						<div class="input-field">
							<input id="search" type="search" name="for" placeholder="@lang('pages.search_details')" class="pr-5 fix-input" required>
							<label class="label-icon" for="search"><i class="material-icons">search</i></label>
							<i class="material-icons">close</i>
						</div>
					</form>
				</li>
			</ul>
		</div>
	</div>
</nav>

<ul class="sidenav" id="mobile-demo">
	@include('includes.nav.menu')

	<div class="divider"></div>
	<li> <!-- Categories -->
		<ul class="collapsible">
			<li>
				<div class="collapsible-header">
					<i class="material-icons">arrow_drop_down</i>
					<span>@lang('includes.categories')</span>
				</div>
				<div class="collapsible-body">
					<ul>
						@include('includes.nav.categories')
					</ul>
				</div>
			</li>
		</ul>
	</li>
</ul>


{{-- {{ request()->is('/') ? 'style="position:absolute;"' : '' }} --}}