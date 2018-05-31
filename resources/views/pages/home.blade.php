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
			<div class="home-edit-form" id="banner-form">
				{!! Form::open(['action' => 'SettingsController@updateBannerData', 'method' => 'POST', 'class' => 'form']) !!}
					<div class="form-group">
						@method('PUT')
						{{ Form::text('title', $title_banner->title, [
							'placeholder' => trans('settings.banner_title')
						]) }}
			
						{{ Form::textarea('text', $title_banner->text, [
							'placeholder' => trans('settings.banner_text')
						]) }}
						{{ Form::submit(trans('form.save'), ['class' => 'blue']) }}
					</div>
				{!! Form::close() !!}
			</div>
		@endadmin
		
		<a class="home-button" id="home-search-btn">
			<i style="background: url('/css/icons/svg/search.svg')"></i>
		</a>

		{{--  Form  --}}
		{!! Form::open(['action' => 'PagesController@search', 'method' => 'GET', 'class' => 'header-search']) !!}
			<div class="form-group" style="position:relative;">
				<div class="home-search" id="search-form">
					{{ Form::text('for', '', ['id' => 'header-search-input', 'placeholder' => trans('pages.search_details')]) }}
					{{ Form::submit('', ['style' => 'display:none']) }}
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
		<div class="home-edit-form" id="intro-form">
			{!! Form::open(['action' => 'SettingsController@updateIntroData', 'method' => 'POST', 'class' => 'form' ]) !!}
	
				@method('PUT')
	
				<div class="form-group">
					{{ Form::text('title', $title_intro->title, [
						'placeholder' => trans('settings.intro_title')
					]) }}
	
					{{ Form::textarea('text', $title_intro->text, [
						'placeholder' => trans('settings.intro_text')
					]) }}
	
					{{ Form::submit(trans('form.save'), ['class' => 'blue']) }}
				</div>
			{!! Form::close() !!}
		</div>
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