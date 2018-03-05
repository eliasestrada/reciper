@extends('layouts.app')

@section('title', 'Поиск')

@section('body')

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
	    @foreach($recipes as $recipe)
		    <section class="recipes">
		        <div>
		            <a href="/recipes/{{ $recipe->id }}">
		                <img src="{{ asset('storage/images/' . $recipe->image) }}" alt="{{ $recipe->title }}" title="{{ $recipe->title }}">
		            </a>
		            <div class="cards-content">
		                <h3>{{ $recipe->title }}</h3>
		                <p>{{ $recipe->intro }}</p>
		                <a href="/search?for={{ $recipe->category }}" title="{{ $recipe->category }}"><span class="category">{{ $recipe->category }}</span></a>
		            </div>
		        </div>
		    </section>
	    @endforeach
	    {{ $recipes->links() }}
	@endif

	<div class="content">
		<h4 class="content center">{{ $message }}</h4>
	</div>


</div>

@endsection