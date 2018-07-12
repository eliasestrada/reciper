@extends('layouts.app')

@section('title', $document->getTitle())

@section('content')

{{-- Breadcrumps --}}
@component('comps.breadcrumps', [
	'url' => ['/admin/documents', '#'],
	'name' => [trans('documents.docs'), $document->getTitle()]
]) @endcomponent

<div class="page">
	<h4>{{ $document->getTitle() }}</h4>
	<div class="reset">{!! customStripTags($document->getText()) !!}</div>
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