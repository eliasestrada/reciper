@isset($categories)
    @foreach ($categories as $category)
        <li>
            <a href="/recipes#category={{ $category['id'] }}" title="{{ $category['name'] }}">
                <i class="fas fa-angle-right fa-15x grey-text left"></i>
                {{ $category['name'] }}
            </a>
        </li>
    @endforeach
@endisset
