@extends('layouts.app')

@section('title', 'Рецепты')

@section('content')

<div class="wrapper">
	<h2 class="headline">Рецепты</h2>

	<div class="container recipes">
		<div class="row">
			@if (count($recipes) > 0)
				@foreach ($recipes as $recipe)
					<div class="recipe-container col-xs-12 col-sm-6 col-md-4 col-lg-3">
						<div class="recipe" style="animation: appear {{ 1 + $loop->index }}s;">
							<a href="/recipes/{{ $recipe->id }}" title="{{ $recipe->title }}">
								<!-- Image -->
								<img src="{{ asset('storage/images/'.$recipe->image) }}" alt="{{ $recipe->title }}">
							</a>
							<div class="recipes-content">
								<!-- Title -->
								<h3>{{$recipe->title}}</h3>
							</div>
						</div>
					</div>
				@endforeach

				{{ $recipes->links() }}

			@else
				<p class="content">Нет рецептов</p>
			@endif

		</div>
	</div>
</div>

@endsection
