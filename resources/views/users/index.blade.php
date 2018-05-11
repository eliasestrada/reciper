@extends('layouts.app')

@section('title', trans('users.all_authors'))

@section('content')

<h2 class="headline">@lang('users.all_authors') {{ $users->count() }}</h2>
<ul class="item-list unstyled-list">

	@foreach ($users as $user)
		<a href="/users/{{ $user->id }}" title="{{ $user->name }}">
			<li>
				<img src="{{ asset('storage/uploads/'.$user->image) }}" alt="{{ $user->name }}" style="width:3.7em;" />
				<div class="item-content">
					<h3 class="project-name">{{ $user->name }}</h3>
					<p class="project-title">@lang('users.online'): {{ facebookTimeAgo( $user->updated_at ) }}</p>
					@admin
						@if (!$user->isAuthor() )
						<div class="block-message-content">
							<p>@lang('users.new_user_1') {{ facebookTimeAgo( $user->created_at ) }} @lang('users.new_user_2')</p>
							
							<a href="/member/{{ $user->id }}/add" class="button-add-user" title="@lang('users.click_to_add')" onclick='return confirm("Вы точно хотите добавить этого пользователя как автора рецептов?")'>@lang('users.add_to_team')</a>
							
							<a href="/member/{{ $user->id }}/delete" class="button-add-user" title="Нажмите чтобы удалить этого пользователя" onclick='return confirm("Вы точно хотите удалить этого пользователя?")'>@lang('users.delete')</a>
						</div>
						@endif
					@endadmin
				</div>
			</li>
		</a>
	@endforeach
</ul>
{{ $users->links() }}

@endsection
