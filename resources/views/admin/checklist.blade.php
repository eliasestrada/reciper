@extends('layouts.app')

@section('title', trans('admin.checklist'))

@section('content')

<h2 class="headline">@lang('admin.checklist')</h2>

{{--  Unapproved recipes  --}}
@admin
	<div class="list-of-recipes">
		<h4 style="margin: .5em;">
			@lang('admin.unapproved') {{ $unapproved->count() }}
		</h4>

		@forelse ($unapproved as $unapprove)
			<div class="each-recipe" data-updated="Обновленно {{ facebookTimeAgo($unapprove->updated_at) }}" data-author="@lang('admin.author'): {{ $unapprove->author }}">

				{{-- Image --}}
				<a href="/recipes/{{ $unapprove->id }}">
					<img src="{{ asset('storage/images/'.$unapprove->image) }}" alt="{{ $unapprove->title }}" title="@lang('admin.to_recipe')">
				</a>

				{{-- Content --}}
				<div class="each-content">
					<span style="font-size: 1.1em;"><b>{{ $unapprove->title }}</b></span>
					<br />
					<span style="color: gray;">{{ $unapprove->intro }}</span>
				</div>
			</div>
		@empty
			<p class="content center">@lang('admin.no_unapproved')</p>
		@endforelse

		{{ $unapproved->links() }}
	</div>
@endadmin

@endsection