@extends('layouts.app')

@section('title', 'Поиск')

@section('content')

<h2 class="headline">Поиск</h2>

{{--  Form  --}}
{!! Form::open(['action' => 'PagesController@search', 'method' => 'GET', 'class' => 'form']) !!}
	<div class="form-group">
		{{ Form::text('for', '', ['placeholder' => 'Введите критерии поиска...']) }}
		{{ Form::submit('', ['style' => 'display:none'])}}
	</div>
{!! Form::close() !!}

{{--  Results  --}}
@if ($recipes)
	<section class="container recipes">
		<div class="row">

			@foreach ($recipes as $recipe)
				<div class="recipe-container col-xs-12 col-sm-6 col-md-4 col-lg-3">
					<div class="recipe">
						<a href="/recipes/{{ $recipe->id }}">
							{{--  Image  --}}
							<img  src="{{ asset('storage/images/'.$recipe->image) }}" alt="{{ $recipe->title }}" title="{{ $recipe->title }}">
						</a>
						<div class="recipes-content">
							{{--  Title  --}}
							<h3>{{ $recipe->title }}</h3>
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

@endsection