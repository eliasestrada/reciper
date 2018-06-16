@extends('layouts.app')

@section('title', trans('includes.notifications'))

@section('content')

<div class="py-4 px-2">
	<div class="center-align">
		<h1 class="headline">
			@lang('includes.notifications') 
			{{ count($notifications) > 0 ? ': '.count($notifications) : '' }}
		</h1>
	</div>
	
	<div class="row py-5">
		@forelse ($notifications as $notification)
			<div class="col s12 m6 l4">
				<div class="card-panel px-3">
					<span class="white-text">
						<h5>{{ $notification->title }}</h5>
						<p>{{ $notification->message }}</p>
						<span class="grey-text right">{{ facebookTimeAgo($notification->created_at) }}</span>
					</span>
				</div>
			</div>
		@empty
			<div class="center-align">
				<p class="flow-text grey-text">@lang('users.u_dont_have_notif')</p>
			</div>
		@endforelse
	</div>
		
	{{ $notifications->links() }}
</div>

@endsection