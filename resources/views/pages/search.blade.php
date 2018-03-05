@extends('layouts.app')

@section('title', 'Поиск')

@section('body')

<div class="wrapper">
    <h2><i class="fa fa-search" aria-hidden="true"></i> Поиск</h2>
    <p>Воспользуйтесь поиском чтобы найти рецепты или категориию рецептов.</p>

	{{--  Form  --}}
	<form action="/search" method="GET" role="search" class="form">
		<div class="form-group">
			<input type="text" name="search_for" placeholder="Искать">
			<input type="submit" value="Поиск" style="display: none;">
		</div>
	</form>

	{{--  Results  --}}
    @if($recipes)
	    @foreach($recipes as $recipe)
		    <section class="recipes">
		        <div>
		            <a href="/recipes/{{ $recipe->id }}">
		                <img src="{{ asset('storage/images/' . $recipe->image) }}" alt="{{ $recipe->title }}" title="{{ $recipe->title }}">
		            </a>
		            <div class="cards-content">
		                <h3>{{ $recipe->title }}</h3>
		                <p>{{ $recipe->intro }}</p>
		                <a href="/search/{{ $recipe->category }}" title="{{ $recipe->category }}"><span class="category">{{ $recipe->category }}</span></a>
		            </div>
		        </div>
		    </section>
	    @endforeach
	    {{ $recipes->links() }}
	@else
		<div class="content">
			<h4>Ничего не найдено</h4>
		</div>
    @endif


</div>

@endsection