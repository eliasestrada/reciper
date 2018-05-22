@extends('layouts.app')

@section('title', trans('users.all_authors'))

@section('content')

<h2 class="content center">@lang('users.all_authors')</h2>

<div class="container">
	<div class="row">
		<ul class="item-list unstyled-list">
			@foreach ($users as $user)
				<a href="/users/{{ $user->id }}" title="{{ $user->name }}">
					<li class="col-md-6 col-lg-4">
						<img src="{{ asset('storage/uploads/'.$user->image) }}" alt="{{ $user->name }}" style="width:3.7em;" />
						<div class="item-content">
							<h3 class="project-name">{{ $user->name }}</h3>
							<p class="project-title">
								@lang('users.online'): {{ facebookTimeAgo( $user->updated_at ) }}
							</p>
							@admin
								@if (!$user->isAuthor() )
								<div class="block-message-content">
									<p>@lang('users.new_user', ['date' => facebookTimeAgo( $user->created_at )])</p>
									
									<a href="/member/{{ $user->id }}/add" class="button-add-user" title="@lang('users.click_to_add')" onclick='return confirm("@lang('users.sure_to_add')")'>
										@lang('users.add_to_team')
									</a>
									
									<a href="/member/{{ $user->id }}/delete" class="button-add-user" title="@lang('users.click_to_delete')" onclick='return confirm("@lang('users.sure_to_delete')")'>
										@lang('users.delete')
									</a>
								</div>
								@endif
							@endadmin
						</div>
					</li>
				</a>
			@endforeach
		</ul>
	</div>
</div>

{{ $users->links() }}

@endsection
