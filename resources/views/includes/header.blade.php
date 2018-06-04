<header class="home-header">
	<div class="header-bg-img"></div>
	<div class="header-bg-overlay"></div>
	<div class="header-content">

		<h1>{{ config('app.name') }}</h1>
		<div class="home-meal">
			@lang('home.what_u_like')<br />
			<a href="search?for={{ trans('home.breakfast') }}">@lang('home.breakfast')</a>, 
			<a href="search?for={{ trans('home.lunch') }}">@lang('home.lunch')</a> @lang('home.or') 
			<a href="search?for={{ trans('home.dinner') }}">@lang('home.dinner')</a>?
		</div>

		{{-- Search button --}}
		<a class="home-button" id="home-search-btn">
			<i style="background: url('/css/icons/svg/search.svg')"></i>
		</a>

		{{--  Form  --}}
		{!! Form::open(['action' => 'PagesController@search', 'method' => 'GET', 'class' => 'header-search']) !!}
			<div class="form-group" style="position:relative;">
				<div class="home-search" id="search-form">
					{{ Form::text('for', '', ['id' => 'header-search-input', 'placeholder' => trans('pages.search_details')]) }}
					{{ Form::submit('', ['class' => 'd-none']) }}
				</div>
			</div>
		{!! Form::close() !!}
	</div>
</header>