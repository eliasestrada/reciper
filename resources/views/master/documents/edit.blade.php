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

    <form action="{{ action('Master\DocumentsController@update', ['id' => $document->id]) }}" method="post">
        <div class="center p-3">

            {{-- Back button --}}
            <a href="/master/documents" class="btn-floating green tooltipped" data-tooltip="@lang('messages.back')" data-position="top">
                <i class="fas fa-angle-left"></i>
            </a>

            {{-- View button --}}
            @if ($document->id != 1)
                <button class="btn-floating green tooltipped" data-tooltip="@lang('tips.view')" data-position="top" name="view">
                    <i class="fas fa-eye"></i>
                </button>
            @endif

            {{-- Save button --}}
            @unless ($document->isReady())
                <button class="btn-floating green tooltipped" data-tooltip="@lang('tips.save')" data-position="top">
                    <i class="fas fa-save"></i>
                </button>
            @endunless
            
            {{-- Delete button --}}
            @if ($document->id != 1)
                <a onclick="if(confirm('@lang('documents.sure_del_doc')')) $('delete-doc').submit()" class="btn-floating red tooltipped" data-tooltip="@lang('tips.delete')" data-position="top">
                    <i class="fas fa-trash"></i>
                </a>
            @endif

            {{-- Move to draft --}}
            @if ($document->id !== 1 && $document->isReady())
                <a href="#" class="btn-floating green tooltipped" id="publish-btn" data-tooltip="@lang('tips.add_to_drafts')" data-position="top" data-alert="@lang('documents.sure_draft_doc')">
                    <i class="material-icons">library_books</i>
                </a>
                <input type="checkbox" name="ready" value="0" class="d-none" id="ready-checkbox">
            @endif

            {{--  Publish button  --}}
            @if ($document->id == 1 || !$document->isReady())
                <a href="#" class="btn-floating green tooltipped" id="publish-btn" data-tooltip="@lang('tips.publish')" data-position="top" data-alert="@lang('documents.sure_publich_doc')">
                    <i class="fas fa-share"></i>
                </a>
                <input type="checkbox" name="ready" value="1" class="d-none" id="ready-checkbox">
            @endif
        </div>

        @csrf
        @method('put')

        <div class="input-field"> {{-- Input field --}}
            <input type="text" name="title" id="title" value="{{ $document->getTitle() }}" class="counter" data-length="{{ config('validation.docs_title_max') }}">
            <label for="title">@lang('documents.doc_title')</label>
        </div>

        <div class="input-field"> {{-- Textarea --}}
            <textarea name="text" id="text" class="materialize-textarea">{!! custom_strip_tags($document->text) !!}</textarea>
            <span class="helper-text">@lang('documents.doc_text')</span>
        </div>
    </form>
</div>

<form action="{{ action('Master\DocumentsController@destroy', ['id' => $document->id]) }}" method="post" id="delete-doc" class="d-none">
    @method('delete') @csrf
</form>

@endsection

@section('script')
    @include('includes.js.tinymse')
@endsection