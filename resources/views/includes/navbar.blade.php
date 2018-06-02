{{--  Hamburger menu  --}}
<div class="regular-menu{{ request()->is('/') ? ' is-home' : '' }}" id="menu-container">
    <div id="hamburger" class="hamburger">
		<span class="lines line1"></span>
		<span class="lines line2"></span>
		<span class="lines line3"></span>
	</div>
</div>

{{--  Navigation menu  --}}
<nav id="nav-menu" class="nav-closed{{ request()->is('/') ? ' is-home' : '' }}">
	<a href="/" title="@lang('includes.home')" id="logo" class="logo-closed">
		<h2>{{ config('app.name') }}</h2>
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

			{{-- Categories --}}
			<a class="categories-title">@lang('includes.categories')</a>

			<div class="arrow-bottom" id="arrow-bottom"></div>
			<div class="categories-menu" id="categories-menu">

				@isset($all_categories)
					@foreach ($all_categories as $category)
						<a href="/search?for={{ $category->category->id }}" title="{{ $category->category->category }}">
							<span>{{ $category->category->category }}</span>
						</a>
					@endforeach
				@endisset

			</div>
		</li>
    </ul>
</nav>