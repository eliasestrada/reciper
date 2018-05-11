@extends('layouts.app')

@section('title', trans('admin.checklist'))

@section('content')

<h2 class="headline">@lang('admin.checklist')</h2>

{{--  Unapproved recipes  --}}
@admin
	<div class="item-list unstyled-list">
		<p class="content center">@lang('admin.unapproved') {{ $unapproved->count() }}</p>

		@forelse ($unapproved as $unapprove)
			<a href="/recipes/{{ $unapprove->id }}" title="{{ $unapprove->title }}">
				<li>
					<img src="{{ asset('storage/images/'.$unapprove->image) }}" alt="{{ $unapprove->title }}" />
					<div class="item-content">
						<h3 class="project-name">{{ $unapprove->title }}</h3>
						<p class="project-title">
							@lang('users.date') {{ facebookTimeAgo($unapprove->created_at) }}
						</p>
					</div>
				</li>
			</a>
		@empty
			<p class="content center">@lang('admin.no_unapproved')</p>
		@endforelse

		{{ $unapproved->links() }}
	</div>
@endadmin

@endsection