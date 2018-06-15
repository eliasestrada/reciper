<ul id="dropdown1" class="dropdown-content">
	@isset($category_names)		
		<li class="categories-menu" id="categories-menu">
			@foreach ($category_names as $name)
				<a href="/search?for={{ str_replace(' ', '-', $name['name_'.locale()]) }}" title="{{ $name['name_'.locale()] }}">
					{{ $name['name_'.locale()] }}
				</a>
			@endforeach
		</li>
	@endisset
</ul>
<nav>
	<div class="nav-wrapper main">
		<div class="px-3 wrapper">
			<a href="/" title="@lang('includes.home')" class="brand-logo">
				{{ config('app.name') }}
			</a>
			<a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>

			<ul class="right hide-on-med-and-down">
				<li class="{{ activeIfRouteIs('/') }}">
					<a href="/" title="На главную">@lang('includes.home')</a>
				</li>
				<li class="{{ activeIfRouteIs('recipes') }}">
					<a href="/recipes" title="Рецепты">@lang('includes.recipes')</a>
				</li>
				<li class="{{ activeIfRouteIs('search') }}">
					<a href="/search" title="Поиск">@lang('includes.search')</a>
				</li>

				<!-- Dropdown Trigger -->
				<li>
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
	<li class="{{ activeIfRouteIs('/') }}">
		<a href="/" title="На главную">@lang('includes.home')</a>
	</li>
	<li class="{{ activeIfRouteIs('recipes') }}">
		<a href="/recipes" title="Рецепты">@lang('includes.recipes')</a>
	</li>
	<li class="{{ activeIfRouteIs('search') }}">
		<a href="/search" title="Поиск">@lang('includes.search')</a>
	</li>
	@foreach ($category_names as $name)
		<li>
			<a href="/search?for={{ str_replace(' ', '-', $name['name_'.locale()]) }}" title="{{ $name['name_'.locale()] }}">
				{{ $name['name_'.locale()] }}
			</a>
		</li>
	@endforeach
</ul>

{{-- {{ request()->is('/') ? 'style="position:absolute;"' : '' }} --}}