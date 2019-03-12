<div class="item-list unstyled-list row {{ ($class ?? '') }}" {{ isset($id) ? 'id=' . $id : '' }}>
    @isset($recipes)
        @forelse ($recipes as $recipe)
            <ul>
                <li style="margin-bottom:5px;border-left-color:{{ $recipe->getStatusColor() }}"
                    class="col s12 m6 l4 row"
                >
                    <a href="/recipes/{{ $recipe->slug}}" class="image-wrapper">
                        <div class="placeholder-image"
                            style="height:auto; padding-bottom:66%; border-radius:2px; {{ setRandomBgColor() }}"
                        ></div>
                        <img class="lazy-load-img"
                            alt="{{ $recipe->getTitle() }}"
                            src="{{ asset('storage/small/recipes/'.$recipe->image) }}"
                        />
                    </a>

                    <div class="item-content">
                        <section>{{ $recipe->getTitle() }}</section>
                        <section>{{ time_ago($recipe->updated_at) }}</section>
                    </div>

                    <div class="mt-3" style="width:35px">
                        <a href="{{ isset($edit) ? "/recipes/{$recipe->slug}/edit" : '#' }}">
                            <span class="tooltipped" data-tooltip="@lang('users.status'): {{ $recipe->getStatusText() }}">
                                <i class="fas {{ $recipe->getStatusIcon() }} circle p-1" style="color:{{ $recipe->getStatusColor() }};border:solid 2px {{ $recipe->getStatusColor() }};animation:appearWithRotate .5s"></i>
                            </span>
                        </a>
                    </div>
                </li>
            </ul>
        @empty
            @isset($no_recipes)
                @component('comps.empty')
                    @slot('text')
                        {{ $no_recipes }}
                    @endslot
                @endcomponent
            @endisset
        @endforelse
    @endisset
</div>

@isset($recipes)
    {{ optional($recipes)->links() }}
@endisset
