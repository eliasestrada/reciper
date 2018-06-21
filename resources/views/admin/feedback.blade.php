@extends('layouts.app')

@section('title', trans('admin.feedback'))

@section('content')

<div class="page">
	<div class="center-align">
		<h1 class="headline">
			@lang('includes.feedback')
			{{ count($feedback) > 0 ? ': ' . count($feedback) : '' }}
		</h1>
	</div>

	<div class="row mt-2">
		@forelse ($feedback as $feed)
			<div class="col s12">
				<div class="card-panel px-3">
					<span class="white-text">
						<h6>{{ $feed->email }}</h6>
						<p>{{ $feed->message }}</p>
						<span class="grey-text right">{{ timeAgo($feed->created_at) }}</span>
					</span>

					{{-- Delete button --}}
					<form action="{{ action('AdminController@feedbackDestroy', ['id' => $feed->id]) }}" method="post" onsubmit="return confirm('@lang('contact.sure_del_feed')')">
						@method('delete') @csrf
						<button type="submit" class="btn red">@lang('form.deleting')</button>
					</form>
				</div>
			</div>
		@empty
			<div class="center-align">
				<p class="flow-text grey-text">@lang('admin.no_messages')</p>
			</div>
		@endforelse
	</div>
</div>

{{ $feedback->links() }}

@endsection