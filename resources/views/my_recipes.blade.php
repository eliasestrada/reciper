@extends('layouts.app')

@section('title', 'Мои рецепты')

@section('content')

	<h2 class="headline">Мои рецепты</h2>

	{{--  All my recipes  --}}
	@if (Auth::user()->author === 1)
		<div class="list-of-recipes">
			@forelse ($recipes as $recipe)
				<div class="each-recipe" data-updated="Дата написания {{ facebookTimeAgo($recipe->updated_at) }}" data-author="Статус: {{ $recipe->approved === 1 ? 'Проверен' : 'Не проверен' }}" style="animation: appear 1.{{ $loop->index }}s;">

					<a href="/recipes/{{ $recipe->id }}">
						<img src="{{ asset('storage/images/'.$recipe->image) }}" alt="{{ $recipe->title }}" title="Перейти к рецепту">
					</a>

					<div class="each-content">
						<span style="font-size: 1.05em;">{{ $recipe->title }}</span>
						<br />
						<span style="color: gray;">{{ $recipe->intro }}</span>
					</div>
				</div>
			@empty
				<p class="content center">У вас пока нет рецептов</p>
			@endforelse

			{{ $recipes->links() }}
		</div>
	@endif

@endsection