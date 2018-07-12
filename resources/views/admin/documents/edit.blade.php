@extends('layouts.app')

@section('title', trans('common.edit_item', ['item' => $document->getTitle()]))

@section('head')
	<script src="{{ URL::to('/js/tinymce/tinymce.min.js') }}"></script>
@endsection

@section('content')

<div class="page">
	<div class="center">
		<h1 class="headline">@lang('common.edit_item', ['item' => $document->getTitle()])</h1>
	</div>

	{{-- Breadcrumps --}}
	@component('comps.breadcrumps', [
		'url' => ['/admin/documents', '#'],
		'name' => [trans('documents.docs'), $document->getTitle(), 20]
	]) @endcomponent

	<form action="{{ action('Admin\DocumentsController@update', ['id' => $document->id]) }}" method="post">
		@csrf @method('put')
		<div class="input-field"> {{-- Input field --}}
			<input type="text" name="title" id="title" value="{{ $document->getTitle() }}" class="counter" data-length="{{ config('validation.docs_title_max') }}">
			<label for="title">@lang('documents.doc_title')</label>
		</div>
		<div class="input-field"> {{-- Textarea --}}
			<textarea name="text" id="text" class="materialize-textarea">{!! customStripTags($document->getText()) !!}</textarea>
			<span class="helper-text">@lang('documents.doc_text')</span>
		</div>

		<div class="fixed-action-btn"> {{-- Floating buttons --}}
			<a href="#" class="btn-floating main btn-large pulse z-depth-3" id="_more">
				<i class="large material-icons">more_vert</i>
			</a>
			<ul>
				<li> {{-- Delete button --}}
					<a onclick="if(confirm('@lang('documents.sure_del_doc')')) $('delete-doc').submit()" class="btn-floating red btn-large tooltipped" data-tooltip="@lang('tips.del_doc')" data-position="left">
						<i class="material-icons large">delete</i>
					</a>
				</li>
				<li> {{-- Save button --}}
					<button class="btn-floating green btn-large tooltipped" data-tooltip="@lang('tips.save_doc')" data-position="left">
						<i class="large material-icons">save</i>
					</button>
				</li>
				<li> {{-- View button --}}
					<button class="btn-floating green btn-large tooltipped" data-tooltip="@lang('tips.view_doc')" data-position="left" name="view">
						<i class="large material-icons">remove_red_eye</i>
					</button>
				</li>
			</ul>
		</div>
	</form>
</div>

<form action="{{ action('Admin\DocumentsController@destroy', ['id' => $document->id]) }}" method="post" id="delete-doc" class="d-none">
	@method('delete') @csrf
	<button type="submit"></button>
</form>

@endsection

@section('script')
	@include('includes.js.counter')
	@include('includes.js.tinymse')
	@include('includes.js.floating-btn')
@endsection