@extends('layouts.app')

@section('content')

<div class="wrapper">
    <h2><i class="fa fa-bell-o bell-alert"></i> Оповещения</h2>

	@if (count($notifications) > 0)
		<div>
			@foreach ($notifications as $notification)
				<div class="content">
					<h3>{{ $notification->title }}</h3>
					<p>{{ $notification->message }}</p>
					<p>{{ $notification->created_at }}</p>
					<hr />
				</div>
			@endforeach
		</div>
		{{ $notifications->links() }}
	@else
		<div class="content">
			<h4>У вас пока нет оповещений</h4>
		</div>
	@endif
</div>

@endsection