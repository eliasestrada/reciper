@extends('layouts.app')

@section('title', trans('pages.home'))

@section('content')

{{--  Home Header  --}}
<header class="home-header">
	<div class="header-bg-img"></div>
	<div class="header-bg-overlay"></div>
	<div class="header-content">

		<h1>{{ title_case(optional($title_banner)->title) }}</h1>
		<h2>{{ title_case(optional($title_banner)->text) }}</h2>
		
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
	<h2 class="headline">{{ title_case(optional($title_intro)->title) }}</h2>
	<p>{{ optional($title_intro)->text }}</p>
</section>

{{--  Cards  --}}
<section class="home-section">
	@if (count($random_recipes) > 0)
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