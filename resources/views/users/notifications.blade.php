@extends('layouts.app')

@section('title', trans('includes.notifications'))

@section('content')

<h1 class="headline">
	@lang('dashboard.notifications') 
	{{ count($notifications) > 0 ? ': '.count($notifications) : '' }}
</h1>

<div class="py-5">
	@forelse ($notifications as $notification)
		<div class="notification">
			<h4 class="notification-title">{{ $notification->title }}</h4>
			<p class="notification-date">{{ facebookTimeAgo($notification->created_at) }}</p>
			<p class="notification-message">{{ $notification->message }}</p>
		</div>
	@empty
		<p class="content text-center">@lang('users.u_dont_have_notif')</p>
	@endforelse
</div>

{{ $notifications->links() }}

@endsection