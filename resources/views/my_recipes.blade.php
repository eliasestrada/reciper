@extends('layouts.app')

@section('title', 'Мои рецепты')

@section('head')
	<style>#my-resipes { border-bottom: 3px solid #a8a8a8; }</style>
@endsection

@section('content')

<div class="wrapper">
	@include('includes.profile-menu-line')
	<h2 class="headline">Мои рецепты</h2>

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
				<p class="content center">У вас пока нет рецептов</p>
			@endif
		</div>
	@endif
</div>

@endsection