@extends('layouts.app')

@section('title', trans('documents.new_doc'))

@section('head')
    <script src="{{ URL::to('/js/tinymce/tinymce.min.js') }}"></script>
@endsection

@section('content')

<div class="page">
    <div class="center">
        <h1 class="headline">@lang('documents.new_doc')</h1>
    </div>

    <form action="{{ action('Master\DocumentsController@store') }}" method="post">
        @csrf

        <div class="center pb-2 pt-3">
            {{-- Back button --}}
            <a href="/master/documents" class="btn-floating green tooltipped" data-tooltip="@lang('messages.back')" data-position="top">
                <i class="fas fa-angle-left"></i>
            </a>
            {{--  Save button  --}}
            <button type="submit" class="btn-floating green tooltipped" data-tooltip="@lang('tips.save')" data-position="top">
                <i class="fas fa-save"></i>
            </button>
        </div>

        <div class="input-field"> {{-- Input field --}}
            <input type="text" name="title" id="title" value="{{ old('title') }}" class="counter" data-length="{{ config('valid.docs.title.max') }}" maxlength="{{ config('valid.docs.title.max') }}" minlength="{{ config('valid.docs.title.min') }}">
            <label for="title">@lang('documents.doc_title')</label>
        </div>

        <div class="input-field"> {{-- Textarea --}}
            <textarea name="text" id="text" class="materialize-textarea"></textarea>
            <span class="helper-text">@lang('documents.doc_text')</span>
        </div>
    </form>
</div>

@endsection

@section('script')
    @include('includes.js.tinymse')
@endsection