@extends('layouts.user')

@section('title', 'Обратная связь')

@section('content')

<div class="wrapper">
	<h2 class="headline">Сообщения: {{ count($feedback) }}</h2>

		@if (count($feedback) > 0)
			<div style="padding: 1em 0;">
				@foreach ($feedback as $feed)
					<div class="notification">
						<h4 class="notification-title">{{ $feed->email }}</h4>
						<p class="notification-date">{{ $feed->name }} ({{ facebookTimeAgo($feed->created_at) }})</p>
						<p class="notification-message">{{ $feed->message }}</p>
					</div>
				@endforeach
			</div>
			{{ $feedback->links() }}
		@else
			<p class="content center">Нет непровереных рецептов</p>
		@endif
</div>

@endsection