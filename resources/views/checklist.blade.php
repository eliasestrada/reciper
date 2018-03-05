@extends('layouts.app')

@section('title', 'Проверочная')

@section('body')

<div class="wrapper">
    <h2 class="content">Проверочная</h2>

	{{--  Unapproved recipes  --}}
    @if (Auth::user()->admin === 1)
        <div class="list-of-recipes">
            @if (count($unapproved) > 0)
                <h3>Рецепты на рассмотрении {{ count($unapproved) }}</h3>
                @foreach ($unapproved as $unapprove)
                    <div class="each-recipe" data-updated="Обновленно {{ facebookTimeAgo($unapprove->updated_at) }}" data-author="Автор: {{ $unapprove->author }}">
                        <a href="/recipes/{{ $unapprove->id }}">
                            <img src="{{ asset('storage/images/'.$unapprove->image) }}" alt="{{ $unapprove->title }}" title="Перейти к рецепту">
                        </a>
                        <div class="each-content">
                            <span>{{ $unapprove->title }}</span>
                            <span>{{ $unapprove->intro }}</span>
                        </div>
                    </div>
                @endforeach
                {{ $unapproved->links() }}
			@else
				<p class="content center">Нет непровереных рецептов</p>
            @endif
        </div>
    @endif
</div>

@endsection