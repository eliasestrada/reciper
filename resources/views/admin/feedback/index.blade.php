@extends('layouts.app')

@section('title', trans('admin.feedback'))

@section('content')

<div class="page">
	<div class="center">
		<h1 class="headline">
			@lang('includes.feedback')
			{{ count($feedback) > 0 ? ': ' . count($feedback) : '' }}
		</h1>
	</div>

	<div class="row mt-2">
		@forelse ($feedback as $feed)
			<div class="col s12">
				<div class="card-panel px-3">
					<span>
						<h6>{{ $feed->email }}</h6>
						<p>{{ $feed->message }}</p>
						<span class="grey-text right">{{ time_ago($feed->created_at) }}</span>
					</span>

					{{-- Delete button --}}
					<form action="{{ action('Admin\FeedbackController@destroy', ['id' => $feed->id]) }}" method="post" onsubmit="return confirm('@lang('contact.sure_del_feed')')">
						
						@method('delete') @csrf

						<button type="submit" class="btn red">@lang('form.deleting')</button>
					</form>
				</div>
			</div>
		@empty
			<div class="center">
				<p class="flow-text grey-text">@lang('admin.no_messages')</p>
			</div>
		@endforelse
	</div>
</div>

{{ $feedback->links() }}

@endsection