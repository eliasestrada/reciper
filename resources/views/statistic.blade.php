@extends('layouts.app')

@section('title', 'Статистика')

@section('content')

<div class="wrapper">
	@include('includes.profile-menu-line')
    <h2 class="headline">Статистика</h2>

	@if (count($visitors) > 0)
		<div style="padding: 1em 0;">
			@foreach ($visitors as $visitor)
				<div class="notification">
					<h4 class="notification-title">{{ $visitor->ip }}</h4>
					<p class="notification-date">{{ $cities[$loop->index] }}</p>
					<p class="notification-message">{{ facebookTimeAgo($visitor->created_at) }}</p>
				</div>
			@endforeach
		</div>
		{{ $visitors->links() }}
	@else
		<p class="content center">У вас пока нет оповещений</p>
	@endif
</div>

@endsection