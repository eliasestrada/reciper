<br>
<a href="{{ $link }}" title="{{ $title }}" class="btn z-depth-1 hoverable waves-effect waves-light m-1 min-w {{ ($class ?? '') }}">
    @isset($icon)
        <i class="fas {{ $icon }} left"></i>
    @endisset
    {{ $title }}
</a>