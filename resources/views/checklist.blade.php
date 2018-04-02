@extends('layouts.user')

@section('title', 'Проверочная')

@section('content')

	<h2 class="headline">Проверочная</h2>

	{{--  Unapproved recipes  --}}
    @if (Auth::user()->admin === 1)
        <div class="list-of-recipes">
			<h4 style="margin: .5em;">
				Рецепты на рассмотрении {{ count($unapproved) }}
			</h4>

			@forelse ($unapproved as $unapprove)
				<div class="each-recipe" data-updated="Обновленно {{ facebookTimeAgo($unapprove->updated_at) }}" data-author="Автор: {{ $unapprove->author }}">

					{{-- Image --}}
					<a href="/recipes/{{ $unapprove->id }}">
						<img src="{{ asset('storage/images/'.$unapprove->image) }}" alt="{{ $unapprove->title }}" title="Перейти к рецепту">
					</a>

					{{-- Content --}}
					<div class="each-content">
						<span style="font-size: 1.1em;"><b>{{ $unapprove->title }}</b></span>
						<br />
						<span style="color: gray;">{{ $unapprove->intro }}</span>
					</div>
				</div>
			@empty
				<p class="content center">Нет непровереных рецептов</p>
			@endforelse

			{{ $unapproved->links() }}
        </div>
    @endif

@endsection