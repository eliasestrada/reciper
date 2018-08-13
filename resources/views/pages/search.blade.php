@extends('layouts.app')

@section('title', trans('pages.search'))

@section('content')

<div class="page">
	<div class="center">
		<h1 class="headline">@lang('pages.search')</h1>
	</div>
	
	{{--  Form  --}}
	<div class="container">
		<form action="{{ action('PagesController@search') }}" method="get">
			<div class="input-field">
				<input type="text" name="for" id="search-input">
				<label for="search-input">@lang('pages.search_details')</label>
				<button type="submit" class="d-none"></button>
			</div>
		</form>
	</div>

	{{--  Results  --}}
	@if (isset($recipes) && !empty($recipes))
		<div class="row">
			@foreach ($recipes as $recipe)
				<div class="col s12 m6 l3">
					<div class="card">
						<div class="card-image waves-effect waves-block waves-light">
							<a href="/recipes/{{ $recipe->id }}" title="{{ $recipe->getTitle() }}">
								<img src="{{ asset('storage/images/small/'.$recipe['image']) }}" alt="{{ $recipe->getTitle() }}" class="activator">
							</a>
						</div>
						<div class="card-content min-h">
							<span class="card-title activator">
								{{ $recipe->getTitle() }}
							</span>
						</div>
						<div class="card-reveal">
							<span class="card-title ">
								{{ $recipe->getTitle() }}
								<i class="material-icons right">close</i>
							</span>
							<p>
								<a href="/recipes/{{ $recipe->id }}" title="{{ $recipe->getTitle() }}">@lang('recipes.go')</a>
							</p>
							<p>{{ $recipe->getIntro() }}</p>
						</div>
					</div>
				</div>
			@endforeach
		</div>
	@endif
	
	@component('comps.empty')
		@slot('text')
			{{ ($message ?? '') }}
		@endslot
	@endcomponent
</div>

@endsection