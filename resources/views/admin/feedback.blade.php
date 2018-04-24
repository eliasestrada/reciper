@extends('layouts.app')

@section('title', trans('admin.feedback'))

@section('content')

<h2 class="headline">@lang('admin.messages') {{ $feedback->count() }}</h2>

<div style="padding: 1em 0;">

	@forelse ($feedback as $feed)
		<div class="notification">
			<h4 class="notification-title">{{ $feed->email }}</h4>
			<p class="notification-date">{{ $feed->name }} ({{ facebookTimeAgo($feed->created_at) }})</p>
			<p class="notification-message">{{ $feed->message }}</p>

			{!! Form::open(['action' => ['AdminController@feedbackDestroy', $feed->id], 'method' => 'POST', 'onsubmit' => 'return confirm("Вы точно хотите удалить этот отзыв?")']) !!}
				{{ method_field('delete') }}
				{{ Form::submit(trans('form.delete'), ['class' => 'button-add-user']) }}
			{!! Form::close() !!}

		</div>
	@empty
		<p class="content center">@lang('admin.no_messages')</p>
	@endforelse
</div>

{{ $feedback->links() }}

@endsection