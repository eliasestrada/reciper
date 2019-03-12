@extends('layouts.auth')

@section('title', trans('common.edit_item', ['item' => $document->getTitle()]))

@section('head')
    <script src="{{ url('/vendor/tinymce/tinymce.min.js') }}"></script>
@endsection

@section('content')

@include('includes.buttons.back', ['url' => '/documents'])

<div class="page">
    <div class="center">
        <h1 class="header">@lang('common.edit_item', ['item' => $document->getTitle()])</h1>
    </div>

    <form action="{{ action('Master\DocumentController@update', [
            'id' => $document->id
        ]) }}"
        method="post"
        id="submit-document-form"
    >
        @csrf
        @method('put')

        <div class="center p-3">
            {{-- View button --}}
            @if ($document->id != 1)
                <input type="submit"
                    value="&#xf06e"
                    name="view"
                    class="fas btn-floating green tooltipped"
                    data-tooltip="@lang('tips.view')"
                />
            @endif

            {{-- Save button --}}
            @unless ($document->isReady())
                <button class="btn-floating green tooltipped" data-tooltip="@lang('tips.save')">
                    <i class="fas fa-save"></i>
                </button>
            @endunless
            
            {{-- Delete button --}}
            @if ($document->id != 1)
            @endif

            {{-- Move to draft --}}
            @if ($document->id !== 1 && $document->isReady())
                <a href="#!"
                    class="btn-floating green tooltipped submit-form-btn"
                    data-tooltip="@lang('tips.add_to_drafts')"
                    data-confirm="@lang('documents.sure_draft_doc')"
                    data-checkbox="move-to-drafts"
                    data-form="submit-document-form"
                >
                    <i class="fas fa-file-upload"></i>
                </a>
                <input
                    type="checkbox"
                    name="ready"
                    value="0"
                    class="hide"
                    id="move-to-drafts"
                />
            @endif

            {{-- Delete document --}}
            <a href="#!"
                class="tooltipped btn-floating red submit-form-btn"
                data-confirm="@lang('documents.sure_del_doc')"
                data-tooltip="@lang('forms.deleting')"
                data-form="delete-doc-form"
            >
                <i class="fas fa-trash"></i>
            </a>

            {{--  Publish button  --}}
            @if ($document->id == 1 || !$document->isReady())
                <a href="#!"
                    class="btn-floating green tooltipped submit-form-btn"
                    data-tooltip="@lang('tips.publish')"
                    data-confirm="@lang('documents.sure_publich_doc')"
                    data-checkbox="publish-document"
                    data-form="submit-document-form"
                >
                    <i class="fas fa-share"></i>
                </a>
                <input type="checkbox"
                    id="publish-document"
                    name="ready"
                    value="1"
                    class="hide"
                />
            @endif
        </div>

        {{-- Title field --}}
        <div class="input-field">
            <input type="text"
                name="title"
                id="title"
                value="{{ $document->getTitle() }}"
                class="counter"
                data-length="{{ config('valid.docs.title.max') }}"
                maxlength="{{ config('valid.docs.title.max') }}"
                minlength="{{ config('valid.docs.title.min') }}"
            />
            <label for="title">@lang('documents.doc_title')</label>

            @include('includes.input-error', ['field' => 'title'])
        </div>

        <div class="mx-3">
            @include('includes.input-error', ['field' => 'text'])
        </div>

        {{-- Textarea --}}
        <div class="input-field">
            <textarea name="text"
                id="text"
                class="materialize-textarea"
            >{!! custom_strip_tags($document->getText()) !!}</textarea>
        </div>
    </form>
</div>

<form action="{{ action('Master\DocumentController@destroy', ['id' => $document->id]) }}"
    method="post"
    class="hide"
    id="delete-doc-form"
>
    @method('delete')
    @csrf
</form>

@endsection

@section('script')
    @include('includes.js.tinymse')
@endsection