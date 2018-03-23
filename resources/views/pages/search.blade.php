@extends('layouts.app')

@section('title', 'Поиск')

@section('content')

<div class="wrapper">
	<h2 class="headline"><i class="fa fa-search"></i> Поиск</h2>
	<br />

	{{--  Form  --}}
	<form action="/search" method="GET" role="search" class="form">
		<div class="form-group">
			<input type="search" name="for" placeholder="Искать">
			<input type="submit" value="Поиск" style="display: none;">
		</div>
	</form>

	{{--  Results  --}}
	@if($recipes)
		<section class="container recipes">
			<div class="row">

				@foreach($recipes as $recipe)
					<div class="recipe-container col-xs-12 col-sm-6 col-md-4 col-lg-3">
						<div class="recipe">
							<a href="/recipes/{{ $recipe->id }}">
								<!-- Image -->
								<img  src="{{ asset('storage/images/'.$recipe->image) }}" alt="{{ $recipe->title }}" title="{{ $recipe->title }}">
							</a>
							<div class="recipes-content">
								<!-- Title -->
								<h3>{{$recipe->title}}</h3>
							</div>
						</div>
					</div>
				@endforeach
				{{ $recipes->links() }}

			</div>
		</section>
	@endif

	<div class="content">
		<h4 class="content center">{{ $message }}</h4>
	</div>
</div>

@endsection