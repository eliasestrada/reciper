@extends('layouts.user')

@section('title', 'Оповещения')

@section('content')

    <h2 class="headline">Оповещения</h2>

	@if (count($notifications) > 0)
		<div style="padding: 1em 0;">
			@foreach ($notifications as $notification)
				<div class="notification">
					<h4 class="notification-title">{{ $notification->title }}</h4>
					<p class="notification-date">{{ facebookTimeAgo($notification->created_at) }}</p>
					<p class="notification-message">{{ $notification->message }}</p>
				</div>
			@endforeach
		</div>
		{{ $notifications->links() }}
	@else
		<p class="content center">У вас пока нет оповещений</p>
	@endif

@endsection