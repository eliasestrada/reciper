@extends('layouts.app')

@section('title', 'Обратная связь')

@section('content')

	<h2 class="headline">Сообщения: {{ $feedback->count() }}</h2>

	<div style="padding: 1em 0;">
		@forelse ($feedback as $feed)
			<div class="notification">
				<h4 class="notification-title">{{ $feed->email }}</h4>
				<p class="notification-date">{{ $feed->name }} ({{ facebookTimeAgo($feed->created_at) }})</p>
				<p class="notification-message">{{ $feed->message }}</p>
				
				{!! Form::open(['action' => ['FeedbackController@destroy', $feed->id], 'method' => 'POST', 'onsubmit' => 'return confirm("Вы точно хотите удалить этот отзыв?")']) !!}
					{{ method_field('delete') }}
					{{ Form::submit('Удалить', ['class' => 'button-add-user']) }}
				{!! Form::close() !!}
				
			</div>
		@empty
			<p class="content center">Нет непровереных рецептов</p>
		@endforelse
	</div>

	{{ $feedback->links() }}

@endsection