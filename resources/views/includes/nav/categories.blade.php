@isset($categories)
    @foreach ($categories as $category)
        @if ($category->id !== 1)
            <li>
                <a href="/recipes#category={{ $category->id }}" title="{{ $category->name }}">
                    {{ $category->name }}
                </a>
            </li>
        @endif
    @endforeach
@endisset