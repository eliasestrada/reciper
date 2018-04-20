@extends('layouts.app')

@section('title', 'Оповещения')

@section('content')

<h2 class="headline">Оповещения</h2>

<div style="padding: 1em 0;">
	@forelse ($notifications as $notification)
		<div class="notification">
			<h4 class="notification-title">{{ $notification->title }}</h4>
			<p class="notification-date">{{ facebookTimeAgo($notification->created_at) }}</p>
			<p class="notification-message">{{ $notification->message }}</p>
		</div>
	@empty
		<p class="content center">У вас пока нет оповещений</p>
	@endforelse
</div>

{{ $notifications->links() }}

@endsection