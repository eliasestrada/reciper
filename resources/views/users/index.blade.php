@extends('layouts.app')

@section('title', 'Все авторы')

@section('head')
	<style>#all-users { border-bottom: 3px solid #a8a8a8; }</style>
@endsection

@section('content')

	<h2 class="headline">Все авторы</h2>

    <section>
		@if (count($users) > 0)
			<ul class="users-list unstyled-list">
				@foreach ($users as $user)
					<li>
						<a href="/users/{{ $user->id }}" title="{{ $user->name }}">
							<img src="{{ asset('storage/uploads/'.$user->image) }}" alt="{{ $user->name }}" />
						</a>
						<div class="user-content">
							<h3 class="project-name">{{ $user->name }}</h3>
							<p class="project-title">В сети: {{ facebookTimeAgo( $user->updated_at ) }}</p>

							@if ( Auth::user()->admin === 1 && $user->author === 0 )
								<div class="block-message-content">
									<p>Этот пользователь зарегестрировался {{ facebookTimeAgo( $user->created_at ) }}, не добавляйте пользователя если вы предварительно не просили его зарегестрироваться.</p>
								
									<a href="/user/{{ $user->id }}/add" class="button-add-user" title="Нажмите чтобы добавить этого пользователя к команде" onclick='return confirm("Вы точно хотите добавить этого пользователя как автора рецептов?")'>Добавить к команде</a>
									<a href="/user/{{ $user->id }}/delete" class="button-add-user" title="Нажмите чтобы удалить этого пользователя" onclick='return confirm("Вы точно хотите удалить этого пользователя?")'>Удалить</a>
								</div>
							@endif

						</div>
					</li>
				@endforeach
			</ul>
            {{ $users->links() }}
        @endif
    </section>

@endsection
