<header class="home-header">
	<div class="header-bg-img"></div>
	<div class="header-content">

		<h1>{{ config('app.name') }}</h1>
		<div class="home-meal">
			@lang('header.what_u_like')<br />
			<a href="search?for={{ trans('header.breakfast') }}">@lang('header.breakfast')</a>, 
			<a href="search?for={{ trans('header.lunch') }}">@lang('header.lunch')</a> @lang('header.or') 
			<a href="search?for={{ trans('header.dinner') }}">@lang('header.dinner')</a>?
		</div>

		{{--  Form  --}}
		<form action="{{ action('PagesController@search') }}" method="get" class="header-search">

			@csrf

			<div class="form-group" style="position:relative;">
				<div class="home-search" id="search-form">
					<input type="text" name="for" id="header-search-input" placeholder="@lang('pages.search_details')">
				</div>
				<button type="submit" class="home-button" id="home-search-btn">
					<i style="background: url('/css/icons/svg/search.svg')"></i>
				</button>
			</div>
		</form>
	</div>
</header>