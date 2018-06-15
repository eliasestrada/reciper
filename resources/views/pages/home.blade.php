@extends('layouts.app')

@section('title', trans('pages.home'))

@section('home-header')
	@include('includes.header')
@endsection

@section('content')

<section class="home-section" style="position:relative;">
	@isset($title_intro)
		<h2 class="headline">{{ title_case($title_intro ?? '') }}</h2>
	@endisset
	@isset($text_intro)
		<p>{{ $text_intro ?? '' }}</p>
	@endisset

	@admin
		{{--  Настройки Интро  --}}
		<a class="edit-btn" title="@lang('home.edit_intro')" id="btn-for-intro">
			<i style="background: url('/css/icons/svg/edit-pencil.svg')"></i>
		</a>
		@component('comps.edit_form')
			@slot('id')
				intro-form
			@endslot
			@slot('action')
				SettingsController@updateIntroData
			@endslot
			@slot('title')
				{{ $title_intro }}
			@endslot
			@slot('text')
				{{ $text_intro }}
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
					<div class="recipe-container m3 col s12">
						<div class="recipe">
							<a href="/recipes/{{ $random->id }}">
								<img src="{{ asset('storage/images/'.$random->image) }}" alt="{{ $random->getTitle() }}">
							</a>
							<div class="recipes-content">
								<h3>{{ $random->getTitle() }}</h3>
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
	<script>
		document.addEventListener('DOMContentLoaded', function() {
			var elems = document.querySelectorAll('.parallax');
			var instances = M.Parallax.init(elems);
		});
	</script>
@endsection