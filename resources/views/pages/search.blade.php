@extends('layouts.app')

@section('title', trans('pages.search'))

@section('content')

{{--  Form  --}}

<form action="{{ action('PagesController@search') }}" method="get" class="form">

	@csrf

	<div class="form-group simple-group">
		<h2 class="form-headline">
			<i class="title-icon" style="background: url('/css/icons/svg/search.svg')"></i>
			@lang('pages.search')
		</h2>

		<input type="text" name="for" id="search-input" placeholder="@lang('pages.search_details')">
		<button type="submit" class="d-none"></button>
	</div>
</form>

{{--  Results  --}}
@if (isset($recipes) && count($recipes) > 0)
	<section class="recipes">
		<div class="row">
			@foreach ($recipes->toArray() as $recipe)
				<div class="recipe-container col-12 col-sm-6 col-md-4 col-lg-3">
					<div class="recipe">

						{{--  Image  --}}
						<a href="/recipes/{{ $recipe['id'] }}">
							<img  src="{{ asset('storage/images/'.$recipe['image']) }}" alt="{{ $recipe['title_'.locale()] }}" title="{{ $recipe['title_'.locale()] }}">
						</a>
						<div class="recipes-content">
							<h3>{{ $recipe['title_'.locale()] }}</h3>
						</div>
					</div>
				</div>
			@endforeach
		</div>
	</section>
@endif

<div class="content">
	<h4 class="content text-center">{{ $message ?? '' }}</h4>
</div>

@endsection