@extends('layouts.app')

@section('title', trans('admin.feedback'))

@section('content')


<h1 class="headline">
	@lang('includes.feedback') 
	{{ count($feedback) > 0 ? count($feedback) : '' }}
</h1>

<div class="py-5">

	@forelse ($feedback as $feed)
		<div class="notification">
			<h4 class="notification-title">{{ $feed->email }}</h4>
			<p class="notification-date">{{ facebookTimeAgo($feed->created_at) }}</p>
			<p class="notification-message">{{ $feed->message }}</p>

			<form action="{{ action('AdminController@feedbackDestroy', ['id' => $feed->id]) }}" method="post" onsubmit="return confirm('@lang('contact.sure_del_feed')')">
				@method('delete')
				@csrf
				<button type="submit" class="btn">@lang('form.deleting')</button>
			</form>
		</div>
	@empty
		<p class="content center-align">@lang('admin.no_messages')</p>
	@endforelse
</div>

{{ $feedback->links() }}

@endsection