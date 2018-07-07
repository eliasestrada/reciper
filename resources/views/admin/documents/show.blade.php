@extends('layouts.app')

@section('title', $document->getTitle())

@section('content')

<div class="center pt-4">
	<h1 class="headline">{{ $document->getTitle() }}</h1>
	<br />
	<a href="/admin/documents" title="@lang('help.back')" class="btn waves-effect waves-light">
		<i class="material-icons left">arrow_left</i>
		@lang('messages.back')
	</a>
</div>

<div class="page">
	<span>{{ $document->getTitle() }}</span>
	<div class="reset">{!! custom_strip_tags($document->getText()) !!}</div>
	<p class="mt-3"><b>@lang('logs.created_at'):</b></p>

	{{-- Created at --}}
	<p>{{ timeAgo($document->created_at) }}</p>

	{{-- Updated At --}}
	<p class="mt-3"><b>@lang('documents.last_update'):</b></p>
	<p>{{ timeAgo($document->updated_at) }}</p>
</div>

<div class="fixed-action-btn">
	<a href="/admin/documents/{{ $document->id }}/edit" class="waves-effect waves-light btn green z-depth-3">
		<i class="material-icons right">edit</i>
		@lang('documents.edit')
	</a>
</div>

@endsection