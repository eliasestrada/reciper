@extends('layouts.app')

@section('title', trans('pages.home'))

@section('home-header')
	@include('includes.header')
@endsection

@section('content')

<section class="home-section position-relative">
	@isset($intro)
		<div class="center">
			<h2 class="headline">{{ ($intro->getTitle() ?? '') }}</h2>
		</div>
		<p>{{ ($intro->getText() ?? '') }}</p>
	@endisset

	@admin
		{{--  Настройки Интро  --}}
		<a class="edit-btn" title="@lang('home.edit_intro')" id="btn-for-intro">
			<i class="material-icons">edit</i>
		</a>

		@editForm
			@slot('id')
				intro-form
			@endslot
			@slot('action')
				SettingsController@updateIntroData
			@endslot
			@slot('title')
				{{ $intro->getTitle() }}
			@endslot
			@slot('text')
				{{ $intro->getText() }}
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
		@endeditForm
	@endadmin
</section>

{{--  Cards  --}}
<section class="home-section">
	@if (isset($random_recipes) && !empty($random_recipes))
		@foreach ($random_recipes->chunk(4) as $chunk)
			<div class="row">
				@foreach ($chunk as $random)
					<div class="col s12 m6 l3">
						<div class="card">
							<div class="card-image waves-effect waves-block waves-light">
								<a href="/recipes/{{ $random->id }}">
									<img class="activator" alt="{{ $random->getTitle() }}" src="{{ asset('storage/images/small/'.$random->image) }}">
								</a>
							</div>
							<div class="card-content min-h">
								<span class="card-title activator">
									{{ $random->getTitle() }}
								</span>
							</div>
							<div class="card-reveal">
								<span class="card-title grey-text">
									{{ $random->getTitle() }}
									<i class="material-icons right">close</i>
								</span>
								<p>
									<a href="/recipes/{{ $random->id }}">@lang('recipes.go')</a>
								</p>
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