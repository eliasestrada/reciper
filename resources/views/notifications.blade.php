@extends('layouts.app')

@section('title', trans('dashboard.notifications'))

@section('content')

<h2 class="headline">@lang('dashboard.notifications')</h2>

<div style="padding: 1em 0;">
	@forelse ($notifications as $notification)
		<div class="notification">
			<h4 class="notification-title">{{ $notification->title }}</h4>
			<p class="notification-date">{{ facebookTimeAgo($notification->created_at) }}</p>
			<p class="notification-message">{{ $notification->message }}</p>
		</div>
	@empty
		<p class="content center">@lang('dashboard.you_do_not_have_notifications')</p>
	@endforelse
</div>

{{ $notifications->links() }}

@endsection