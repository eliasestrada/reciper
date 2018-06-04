@extends('layouts.app')

@section('title', trans('pages.home'))

@section('content')

{{--  Home Header  --}}
@include('includes.header')

<section class="home-section" style="position:relative;">
	<h2 class="headline">{{ title_case($title_intro->title ?? '') }}</h2>
	<p>{{ $title_intro->text ?? '' }}</p>

	@admin
		{{--  Настройки Интро  --}}
		<a class="edit-btn" title="@lang('home.edit_intro')" id="btn-for-intro">
			<i style="background: url('/css/icons/svg/edit-pencil.svg')"></i>
		</a>
		@component('components.home_edit_form', ['array' => $title_intro])
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