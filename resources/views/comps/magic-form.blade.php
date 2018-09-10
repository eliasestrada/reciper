{{-- For footer and home page forms --}}
<div class="magic-form" id="{{ $id }}">
    <form action="{{ action($action) }}" method="post" class="p-3">

        @method('put')
        @csrf

        @if (isset($title) && isset($holder_title) && isset($slug_title))
            <div class="input-field">
                <input placeholder="{{ $holder_title }}" id="first_name{{ $slug_title }}" type="text" class="validate" value="{{ $title }}" name="title">
                <label for="first_name{{ $slug_title }}">{{ $holder_title }}</label>
            </div>
        @endif

        @if (isset($text) && isset($holder_text) && isset($slug_text))
            <div class="input-field">
                <textarea id="textarea2{{ $slug_text }}" class="materialize-textarea" data-length="120" name="text">{{ $text }}</textarea>
                <label for="textarea2{{ $slug_text }}">{{ $holder_text }}</label>
            </div>
        @endif

        <div class="input-field">
            <button type="submit" class="btn">@lang('form.save')</button>
        </div>

    </form>
</div>