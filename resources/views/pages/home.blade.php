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
			{!! Form::open([
				'action' => 'SettingsController@updateBannerData',
				'method' => 'POST',
				'class' => 'form none',
				'id' => 'banner-form'
			]) !!}
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
		@endadmin
		
		<a class="home-button" id="home-search-btn">
			<i style="background: url('/css/icons/svg/search.svg')"></i>
		</a>

		{{--  Form  --}}
		{!! Form::open(['action' => 'PagesController@search', 'method' => 'GET', 'class' => 'header-search']) !!}
			<div class="form-group">
				{{ Form::text('for', '', ['id' => 'header-search-input', 'placeholder' => trans('pages.search_details')]) }}
				{{ Form::submit('', ['style' => 'display:none']) }}
			</div>
		{!! Form::close() !!}
	</div>
</header>

<section class="home-section">
	<h2 class="headline">{{ title_case($title_intro->title ?? '') }}</h2>
	<p>{{ $title_intro->text ?? '' }}</p>

	@admin
		{{--  Настройки Интро  --}}
		<a class="edit-btn" title="@lang('home.edit_intro')" id="btn-for-intro">
			<i style="background: url('/css/icons/svg/edit-pencil.svg')"></i>
		</a>
		{!! Form::open([
			'action' => 'SettingsController@updateIntroData',
			'method' => 'POST',
			'class' => 'form none',
			'id' => 'intro-form'
		]) !!}

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
	@endadmin
</section>

{{--  Cards  --}}
<section class="home-section">
	@if (isset($random_recipes) && (count($random_recipes) > 0))
		@foreach ($random_recipes->chunk(3) as $chunk)
			<div class="row">
				@foreach ($chunk as $random)
					<div class="recipe-container col-xs-12 col-sm-6 col-md-4" style="animation: appear {{ 2 + $loop->index }}s;">
						<div class="recipe">

							<a href="/recipes/{{ $random->id }}">
								<img src="{{ asset('storage/images/'.$random->image) }}" alt="{{ $random->title }}">
							</a>
							
							<div class="recipes-content">

								{{-- Title --}}
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

@section('script')
<script defer>
	document.getElementById('home-search-btn').addEventListener('click', () => {
		id("home-search-btn").style.display = "none"
		id("header-search-input").style.display = "block"
	
		setTimeout(() => id("header-search-input").style.opacity = "1", 500)
	})
</script>
@endsection