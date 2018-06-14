@extends('layouts.app')

@section('title', $user->name)

@section('content')

<div class="profile-header">
	<h1>{{ $user->name }}</h1>
	<img src="{{ asset('storage/uploads/'.$user->image) }}" alt="{{ $user->name }}" />
	<div class="content text-center mt-3">
		<p>@include('icons.heart') {{ $likes }}</p>
		<p>@lang('users.joined'): {{ facebookTimeAgo($user->created_at) }}</p>
		<p>@lang('users.online'): {{ facebookTimeAgo($user->updated_at) }}</p>
	</div>
</div>

{{--  All my recipes  --}}
@component('comps.list_of_recipes', ['recipes' => $recipes])
	@slot('title')
		@lang('users.all_recipes')
	@endslot
	@slot('no_recipes')
		@lang('users.this_user_does_not_have_recipes')
	@endslot
@endcomponent

@endsection