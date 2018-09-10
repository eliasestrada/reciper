@isset($categories)
    @foreach ($categories as $category)
            <li>
                <a href="/recipes#category={{ $category->id }}" title="{{ $category->getName() }}">
                    {{ $category->getName() }}
                </a>
            </li>
    @endforeach
@endisset