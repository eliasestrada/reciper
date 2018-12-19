
@if ($errors->has($field))
    <span class="helper-text red-text" data-error="wrong">
        {{ $errors->first($field) }}
    </span>
@endif