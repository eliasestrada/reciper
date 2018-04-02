@extends('layouts.user')

@section('title', 'Обратная связь')

@section('content')

	<h2 class="headline">Сообщения: {{ count($feedback) }}</h2>

	<div style="padding: 1em 0;">
		@forelse ($feedback as $feed)
			<div class="notification">
				<h4 class="notification-title">{{ $feed->email }}</h4>
				<p class="notification-date">{{ $feed->name }} ({{ facebookTimeAgo($feed->created_at) }})</p>
				<p class="notification-message">{{ $feed->message }}</p>
			</div>
		@empty
			<p class="content center">Нет непровереных рецептов</p>
		@endforelse
	</div>

	{{ $feedback->links() }}

@endsection