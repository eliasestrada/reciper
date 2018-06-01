@extends('layouts.app')

@section('title', trans('pages.home'))

@section('content')

{{--  Home Header  --}}
<header class="home-header">
	<div class="header-bg-img"></div>
	<div class="header-bg-overlay"></div>
	<div class="header-content">

		<h1>{{ title_case($title_banner->title ?? '') }}</h1>
		<h2>{{ title_case($title_banner->text ?? '') }}</h2>

		{{-- Настройки Баннера --}}
		@admin
			<a class="edit-btn" title="@lang('home.edit_banner')" id="btn-for-banner">
				<i style="background: url('/css/icons/svg/edit-pencil.svg')"></i>
			</a>
			@component('components.home_edit_form.blade', ['array' => $title_banner])
				@slot('id')
					banner-form
				@endslot
				@slot('action')
					SettingsController@updateBannerData
				@endslot
				@slot('holder_title')
					@lang('settings.banner_title')
				@endslot
				@slot('holder_text')
					@lang('settings.banner_text')
				@endslot
			@endcomponent
		@endadmin
		
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

<section class="home-section" style="position:relative;">
	<h2 class="headline">{{ title_case($title_intro->title ?? '') }}</h2>
	<p>{{ $title_intro->text ?? '' }}</p>

	@admin
		{{--  Настройки Интро  --}}
		<a class="edit-btn" title="@lang('home.edit_intro')" id="btn-for-intro">
			<i style="background: url('/css/icons/svg/edit-pencil.svg')"></i>
		</a>
		@component('components.home_edit_form.blade', ['array' => $title_intro])
			@slot('id')
				intro-form
			@endslot
			@slot('action')
				SettingsController@updateIntroData
			@endslot
			@slot('holder_title')
				@lang('settings.intro_title')
			@endslot
			@slot('holder_text')
				@lang('settings.intro_text')
			@endslot
		@endcomponent
	@endadmin
</section>

{{--  Cards  --}}
<section class="home-section">
	@if (isset($random_recipes) && (count($random_recipes) > 0))
		@foreach ($random_recipes->chunk(4) as $chunk)
			<div class="row">
				@foreach ($chunk as $random)
					<div class="recipe-container col-md-3 col-12 col-sm-6">
						<div class="recipe">
							<a href="/recipes/{{ $random->id }}">
								<img src="{{ asset('storage/images/'.$random->image) }}" alt="{{ $random->title }}">
							</a>
							<div class="recipes-content">
								<h3>{{ $random->title }}</h3>
							</div>
						</div>
					</div>
				@endforeach
			</div>
		@endforeach
	@endif
</section>

@endsection