@extends('layouts.app')

@section('title', trans('common.edit_item', ['item' => $document->getTitle()]))

@section('head')
	<script src="{{ URL::to('/js/tinymce/tinymce.min.js') }}"></script>
@endsection

@section('content')

<div class="center pt-4">
	<h1 class="headline">@lang('common.edit_item', ['item' => $document->getTitle()])</h1>
	<br />
	<a href="/admin/documents/{{ $document->id }}" title="@lang('help.back')" class="btn waves-effect waves-light">
		<i class="material-icons left">arrow_left</i>
		@lang('messages.back')
	</a>
</div>

<div class="page">
	<form action="{{ action('Admin\DocumentsController@update', ['id' => $document->id]) }}" method="post">
		@csrf @method('put')
		<div class="input-field">
			<input type="text" name="title" id="title" value="{{ $document->getTitle() }}" class="counter">
			<label for="title">@lang('documents.doc_title')</label>
		</div>
		<div class="input-field">
			<textarea name="text" id="text" class="materialize-textarea counter">{!! custom_strip_tags($document->getText()) !!}</textarea>
			<span class="helper-text">@lang('documents.doc_text')</span>
		</div>
		<div class="fixed-action-btn">
			<button class="waves-effect waves-light btn green z-depth-3">
				<i class="material-icons right">save</i>
				@lang('form.save')
			</button>
		</div>
	</form>
</div>

@endsection

@section('script')
	@include('includes.js.counter')
	@include('includes.js.tinymse')
@endsection