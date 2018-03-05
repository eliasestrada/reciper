@extends('layouts.app')

@section('title', 'Поиск')

@section('body')

<div class="wrapper">
    <h2><i class="fa fa-search" aria-hidden="true"></i> Поиск</h2>
    <p>Воспользуйтесь поиском чтобы найти рецепты или категориию рецептов.</p>

    {!! Form::open(['action' => ['RecipesController@search', $recipe->id], 'method' => 'get']) !!}
    	{{ Form::text('word', null, ['placeholder' => 'Искать']) }}
    	{{ Form::submit('', ['style', 'display: none;']) }}
    {!! Form::close() !!}

    <!-- Results -->
    @if(count($recipes) > 0)
	    @foreach($resipes as $recipe)
		    <section class="recipes">
		        <div>
		            <a href="/recipes/{{ $recipe->id }}">
		                <img src="{{ asset('storage/images/' . $recipe->image . ') }}" alt="{{ $recipe->title }}" title="{{ $recipe->title }}">
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
			<h3>Ничего не найдено</h3>
		</div>
    @endif
</div>

@endsection