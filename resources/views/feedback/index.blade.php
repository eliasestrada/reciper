@extends('layouts.app')

@section('title', 'Обратная связь')

@section('content')

<div class="wrapper">
	@include('includes.profile-menu-line')
	<h2 class="headline">Обратная связь</h2>

	<div class="list-of-recipes">
		@if (count($feedback) > 0)
			<h4 style="margin: .5em;">Сообщения от посетителей {{ count($feedback) }}</h4>
			@foreach ($feedback as $feed)
				<div class="each-recipe" data-updated="Обновленно {{ facebookTimeAgo($feed->created_at) }}" data-author="Автор: {{ $feed->name }}">
					<img src="{{ asset('storage/other/default_feedback.jpg') }}">
					<div class="each-content">
						<span>{{ $feed->message }}</span>
					</div>
				</div>
			@endforeach
			{{ $feedback->links() }}
		@else
			<p class="content center">Нет непровереных рецептов</p>
		@endif
	</div>
</div>

@endsection