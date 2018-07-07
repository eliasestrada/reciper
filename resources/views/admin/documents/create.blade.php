@extends('layouts.app')

@section('title', trans('documents.new_doc'))

@section('head')
	<script src="{{ URL::to('/js/tinymce/tinymce.min.js') }}"></script>
@endsection

@section('content')

{{-- Breadcrumps --}}
@component('comps.breadcrumps', [
	'url' => ['/admin/documents', '#'],
	'name' => [trans('documents.docs'), trans('documents.new_doc')]
]) @endcomponent

<div class="center pt-4">
	<h1 class="headline">@lang('documents.new_doc')</h1>
</div>

<div class="page">
	<form action="{{ action('Admin\DocumentsController@store') }}" method="post">
		@csrf
		<div class="input-field"> {{-- Input field --}}
			<input type="text" name="title" id="title" value="{{ old('title') }}" class="counter">
			<label for="title">@lang('documents.doc_title')</label>
		</div>
		<div class="input-field"> {{-- Textarea --}}
			<textarea name="text" id="text" class="materialize-textarea"></textarea>
			<span class="helper-text">@lang('documents.doc_text')</span>
		</div>

		<div class="fixed-action-btn"> {{-- Floating buttons --}}
			<a href="#" class="btn-floating main btn-large pulse z-depth-3" id="_more">
				<i class="large material-icons">more_vert</i>
			</a>
			<ul>
				<li> {{-- Save button --}}
					<button class="btn-floating green btn-large tooltipped" data-tooltip="@lang('tips.save_doc')" data-position="left">
						<i class="large material-icons">save</i>
					</button>
				</li>
			</ul>
		</div>
	</form>
</div>

@endsection

@section('script')
	@include('includes.js.counter')
	@include('includes.js.tinymse')
	@include('includes.js.floating-btn')
@endsection