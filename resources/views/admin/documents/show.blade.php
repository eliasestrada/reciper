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
	<div class="reset">{!! customStripTags($document->text) !!}</div>

	<p class="mt-5"> {{-- Created at --}}
		<b>@lang('logs.created_at'):</b> 
		{{ timeAgo($document->created_at) }}
	</p>

	<p> {{-- Updated At --}}
		<b>@lang('documents.last_update'):</b> 
		{{ timeAgo($document->updated_at) }}
	</p>
</div>

{{-- Edit button --}}
@component('comps.btns.fixed-btn')
	@slot('icon') edit @endslot
	@slot('link') /admin/documents/{{ $document->id }}/edit @endslot
	@slot('tip') @lang('tips.edit_doc') @endslot
@endcomponent

@endsection