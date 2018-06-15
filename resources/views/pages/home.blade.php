@extends('layouts.app')

@section('title', trans('pages.home'))

@section('home-header')
	@include('includes.header')
@endsection

@section('content')

<section class="home-section" style="position:relative;">
	@isset($title_intro)
		<div class="center-align">
			<h2 class="headline">{{ title_case($title_intro ?? '') }}</h2>
		</div>
	@endisset
	@isset($text_intro)
		<p>{{ $text_intro ?? '' }}</p>
	@endisset

	@admin
		{{--  Настройки Интро  --}}
		<a class="edit-btn" title="@lang('home.edit_intro')" id="btn-for-intro">
			<i class="material-icons">edit</i>
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
				@lang('home.intro_title')
			@endslot
			@slot('slug_title')
				intro_title
			@endslot
			@slot('holder_text')
				@lang('home.intro_text')
			@endslot
			@slot('slug_text')
				intro_text
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
					<div class="col s12 m6 l3">
						<div class="card">
							<div class="card-image waves-effect waves-block waves-light">
								<img class="activator" src="{{ asset('storage/images/'.$random->image) }}">
							</div>
							<div class="card-content">
								<span class="card-title activator grey-text text-darken-4">
									{{ $random->getTitle() }}
									<i class="material-icons right">more_vert</i>
								</span>
								<p>
									<a href="/recipes/{{ $random->id }}">This is a link</a>
								</p>
							</div>
							<div class="card-reveal">
								<span class="card-title grey-text text-darken-4">
									{{ $random->getTitle() }}
									<i class="material-icons right">close</i>
								</span>
								<p>{{ $random->getIntro() }}</p>
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