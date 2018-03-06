@extends('layouts.app')

@section('title', $user->name)

@section('body')

<div class="wrapper">
	<div class="profile-header">
		<img src="{{ asset('storage/uploads/'.$user->image) }}" alt="{{ $user->name }}" />
		<h1>{{ $user->name }}</h1>
		<p class="content center">В сети: {{ facebookTimeAgo($user->updated_at) }}</p>
	</div>
</div>

@endsection