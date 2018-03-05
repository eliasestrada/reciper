@extends('layouts.app')

@section('title', 'Мои рецепты')

@section('body')

<div class="wrapper">
	<h2>Мои рецепты</h2>

	{{--  All my recipes  --}}
	@if (Auth::user()->author === 1)
	<div class="list-of-recipes">
		@if (count($recipes) > 0)
			@foreach ($recipes as $recipe)
				<div class="each-recipe" data-updated="Дата написания {{ facebookTimeAgo($recipe->updated_at) }}" data-author="Статус: {{ $recipe->approved === 1 ? 'Проверен' : 'Не проверен' }}">
					<a href="/recipes/{{ $recipe->id }}">
						<img src="{{ asset('storage/images/'.$recipe->image) }}" alt="{{ $recipe->title }}" title="Перейти к рецепту">
					</a>
					<div class="each-content">
						<span>{{ $recipe->title }}</span>
						<span>{{ $recipe->intro }}</span>
					</div>
				</div>
			@endforeach
			{{ $recipes->links() }}
		@else
			<div class="content">
				<h4>У вас пока нет рецептов</h4>
			</div>
		@endif
	</div>
	@endif
</div>

@endsection