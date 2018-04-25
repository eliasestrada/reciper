{{--  Hamburger menu  --}}
<div class="regular-menu" id="menu-container">
    <div id="hamburger" class="hamburger">
		<span class="lines line1"></span>
		<span class="lines line2"></span>
		<span class="lines line3"></span>
	</div>
</div>

{{--  Navigation menu  --}}
<nav id="nav-menu" class="nav-closed">
	<a href="/" title="@lang('includes.home')" id="logo" class="logo-closed">
		<img src="{{ asset('storage/other/logo.png') }}" alt="@lang('includes.logo')">
    </a>
    <ul>
		<li class="{{ activeIfRouteIs('/') }}">
			<a href="/" title="На главную">@lang('includes.home')</a>
		</li>
		<li class="{{ activeIfRouteIs('recipes') }}">
			<a href="/recipes" title="Рецепты">@lang('includes.recipes')</a>
		</li>
		<li class="{{ activeIfRouteIs('search') }}">
			<a href="/search" title="Поиск">@lang('includes.search')</a>
		</li>
		<li id="categories-button" class="categories-button">

			{{-- This categories-title working with JS --}}
			<a class="categories-title">Категории</a>

			<div class="arrow-bottom" id="arrow-bottom"></div>
			<div class="categories-menu" id="categories-menu">

				@foreach ($all_categories as $category)
					<a href="/search?for={{ $category['category'] }}" title="{{ $category['category'] }}">
						<span>{{ $category['category'] }}</span>
					</a>
				@endforeach

			</div>
		</li>
    </ul>
</nav>