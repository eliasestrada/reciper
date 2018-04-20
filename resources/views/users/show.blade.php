@extends('layouts.app')

@section('title', $user->name)

@section('content')

<div class="profile-header">
	<h1>{{ $user->name }}</h1>
	<img src="{{ asset('storage/uploads/'.$user->image) }}" alt="{{ $user->name }}" />
	<p class="content center">В сети: {{ facebookTimeAgo($user->updated_at) }}</p>
</div>

<div class="container">
	{{--  All my recipes  --}}
	<div class="list-of-recipes">
		<p class="content center">Всего рецептов: {{ $recipes->count() }}</p>

		@forelse ($recipes as $recipe)
			<div class="each-recipe" data-updated="Дата написания {{ facebookTimeAgo($recipe->updated_at) }}" data-author="Статус: {{ $recipe->approved === 1 ? 'Проверен' : 'Не проверен' }}">

				<a href="/recipes/{{ $recipe->id }}">
					<img src="{{ asset('storage/images/'.$recipe->image) }}" alt="{{ $recipe->title }}" title="Перейти к рецепту">
				</a>

				<div class="each-content">
					<span>{{ $recipe->title }}</span>
					<span>{{ $recipe->intro }}</span>
				</div>
			</div>
		@empty
			<p class="content center">У этого автора нет пока рецептов</p>
		@endforelse

		{{ $recipes->links() }}
	</div>
</div>

@endsection