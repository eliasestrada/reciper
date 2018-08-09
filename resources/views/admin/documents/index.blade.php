@extends('layouts.app')

@section('title', trans('documents.docs'))

@section('content')

<div class="center pt-4"><h1 class="headline">@lang('documents.docs')</h1></div>

{{-- Breadcrumps --}}
@component('comps.breadcrumps', [
	'url' => ['#'],
	'name' => [trans('documents.docs')]
]) @endcomponent
            

<div class="page">
	<div class="row">
		@foreach ($documents as $doc)
			<div class="col s12 l6">
				<div class="card" style="min-height:320px">
				<div class="card-content">
					<span class="card-title">{{ $doc->getTitle() }}</span>
					<p>{{ str_limit(strip_tags($doc->text), 250) }}</p>
					<p class="mt-3"><b>@lang('documents.last_update'):</b></p>
					<p>{{ timeAgo($doc->updated_at) }}</p>
				</div>
				<div class="card-action">
					<a href="/admin/documents/{{ $doc->id }}" class="main-dark-text">@lang('documents.open')</a>
					<a href="/admin/documents/{{ $doc->id }}/edit" class="main-dark-text">@lang('documents.edit')</a>
				</div>
				</div>
			</div>
		@endforeach
	</div>
</div>

@component('comps.btns.fixed-btn')
	@slot('icon') add @endslot
	@slot('link') /admin/documents/create @endslot
	@slot('tip') @lang('documents.new_doc') @endslot
@endcomponent

@endsection