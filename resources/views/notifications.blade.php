@extends('layouts.app')

@section('content')

<div class="wrapper">
    <h2><i class="fa fa-bell-o bell-alert"></i> Оповещения</h2>

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
</div>

@endsection