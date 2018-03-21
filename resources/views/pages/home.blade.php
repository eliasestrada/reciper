@extends('layouts.app')

@section('title', 'Главная')

@section('content')
    <!-- Home Header -->
    <header class="home-header">
        <div class="header-bg-image"></div>
        <div class="header-content">
            <h1>Delicious Food</h1>
            <h2>Рецепты от простых до необычных</h2>
            <a href="/search" class="home-button"><i class="fa fa-search"></i></a>
        </div>
    </header>

    <section class="home-section">
		<h2 class="headline">Готовим вместе</h2>
		<p>Хотелось бы поделиться с вами кулинарными секретами. Здесь вы найдете самые проверенные и оригинальные рецепты, от простых до необычных, и, главное, совсем не сложных в приготовлении. Больше Вам не придется долго искать действительно проверенный и вкусный рецепт!</p>
    </section>

    <!-- Cards -->
    <section class="home-section">
		@if (count($random_recipes) > 0)
			@foreach ($random_recipes->chunk(3) as $chunk)
				<div class="row">
					@foreach ($chunk as $random)
						<div class="recipe-container col-xs-12 col-sm-6 col-md-4">
							<div class="recipe">
								<a href="/recipes/{{ $random->id }}">
									<img src="{{ asset('storage/images/'.$random->image) }}" alt="{{$random->title}}" title="{{$random->title}}">
								</a>
								<div class="recipes-content">
									<!-- Title -->
									<h3>{{$random->title}}</h3>
								</div>
							</div>
						</div>
					@endforeach
				</div>
			@endforeach
		@endif
    </section>
@endsection