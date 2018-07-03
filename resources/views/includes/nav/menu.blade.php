<li class="{{ activeIfRouteIs('/') }}">
	<a href="/" title="@lang('includes.home')">
		<i class="material-icons left">home</i>
		@lang('includes.home')
	</a>
</li>
<li class="{{ activeIfRouteIs('recipes') }}">
	<a href="/recipes" title="@lang('includes.recipes')">
		<i class="material-icons left">restaurant</i>
		@lang('includes.recipes')
	</a>
</li>
<li>
	<a href="#" title="@lang('includes.search')">
		<i class="material-icons left">search</i>
		@lang('includes.search')
	</a>
</li>