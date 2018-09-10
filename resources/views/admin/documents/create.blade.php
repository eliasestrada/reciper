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

    {{-- Breadcrumps --}}
    @component('comps.breadcrumps', [
        'url' => ['/admin/documents', '#'],
        'name' => [trans('documents.docs'), trans('documents.new_doc')]
    ]) @endcomponent

    <form action="{{ action('Admin\DocumentsController@store') }}" method="post">
        @csrf

        <div class="center pb-2 pt-3"> {{--  Save button  --}}
            <button type="submit" class="btn green">
                <i class="material-icons left">save</i>
                @lang('tips.save')
            </button>
        </div>

        <div class="input-field"> {{-- Input field --}}
            <input type="text" name="title" id="title" value="{{ old('title') }}" class="counter" data-length="{{ config('validation.docs_title_max') }}">
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
    @include('includes.js.counter')
    @include('includes.js.tinymse')
@endsection