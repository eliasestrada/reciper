@extends('layouts.app')

@section('title', trans('users.all_authors'))

@section('content')

<div class="center-align pt-4">
	<h1 class="headline">@lang('users.all_authors')</h1>
</div>

<div class="px-2">
	<ul class="item-list unstyled-list">
		@foreach ($users as $user)
			<a href="/users/{{ $user->id }}" title="{{ $user->name }}" >
				<li>
					<img src="{{ asset('storage/uploads/'.$user->image) }}" alt="{{ $user->name }}" style="width:67px; height:71px;" />

					<div class="item-content">
						<h6 class="project-name">{{ $user->name }}</h6>
						<p class="project-title">
							{!! getOnlineIcon(facebookTimeAgo($user->last_visit_at)) !!}
							@lang('date.online') 
							{{ facebookTimeAgo($user->last_visit_at, 'online') }}
						</p>

						@admin
							@if (!$user->isAuthor() )
								<p>
									@lang('users.new_user', ['date' => facebookTimeAgo($user->created_at )])
								</p>
								
								<a href="/member/{{ $user->id }}/add" class="btn d-inline-block green" title="@lang('users.click_to_add')" onclick='return confirm("@lang('users.sure_to_add')")'>
									@lang('users.add_to_team')
								</a>
								
								<a href="/member/{{ $user->id }}/delete" class="btn d-inline-block red" title="@lang('users.click_to_delete')" onclick='return confirm("@lang('users.sure_to_delete')")'>
									@lang('users.delete')
								</a>
							@endif
						@endadmin

					</div>
				</li>
			</a>
		@endforeach
	</ul>
</div>

{{ $users->links() }}

@endsection
