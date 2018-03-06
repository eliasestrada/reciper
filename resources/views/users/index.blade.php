@extends('layouts.app')

@section('title', 'Все авторы')

@section('head')
	<style>#all-users { border-bottom: 3px solid #a8a8a8; }</style>
@endsection

@section('content')

<div class="wrapper">
	@include('includes.profile-menu-line')
    <h2 class="headline">Все авторы</h2>
    <section>

        @if (count($users) > 0)
			@foreach ($users as $user)
				<ul class="users-list unstyled-list">
					<li>
						<a href="/users/{{ $user->id }}" title="{{ $user->name }}">
							<img src="{{ asset('storage/uploads/'.$user->image) }}" alt="{{ $user->name }}" />
						</a>
						<div class="user-content">
							<h3 class="project-name">{{ $user->name }}</h3>
							<p class="project-title">В сети: {{ facebookTimeAgo($user->updated_at) }}</p>
						</div>
					</li>
				</ul>
            @endforeach

            {{ $users->links() }}
        @endif
    </section>
</div>

@endsection
