@isset($categories)
    @foreach ($categories as $category)
        @if ($category['id'] != 1)
            <li>
                <a href="/recipes#category={{ $category['id'] }}" title="{{ $category['name'] }}">
                    <i class="fas fa-angle-right fa-15x grey-text left"></i> 
                    {{ $category['name'] }}
                </a>
            </li>
        @endif
    @endforeach
@endisset