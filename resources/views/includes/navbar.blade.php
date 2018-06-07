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
			@isset($category_names)
				<a class="categories-title">@lang('includes.categories')</a>

				<div class="arrow-bottom" id="arrow-bottom"></div>
				<div class="categories-menu" id="categories-menu">
					@foreach ($category_names as $name)
						<a href="/search?for={{ str_replace(' ', '-', $name) }}" title="{{ $name }}">
							<span>{{ $name }}</span>
						</a>
					@endforeach
				</div>
			@endisset
		</li>
    </ul>
</nav>