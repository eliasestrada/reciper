<div class="item-list unstyled-list row {{ ($class ?? '') }}" {{ isset($id) ? 'id=' . $id : '' }}>
    @isset($recipes)
        @forelse ($recipes as $recipe)
            <ul>
                <li style="margin-bottom:5px;border-left-color:{{ $recipe->getStatusColor() }};" class="col s12 m6 l4 row">
                    <a href="/recipes/{{ $recipe->id }}">
                        <img src="{{ asset('storage/small/images/'.$recipe->image) }}" alt="{{ $recipe->getTitle() }}" />
                    </a>

                    <div class="item-content">
                        <section>{{ str_limit($recipe->getTitle(), 45) }}</section>
                        <section>{{ time_ago($recipe->updated_at) }}</section>
                    </div>

                    <div class="mt-3" style="width:35px">
                        <span class="tooltipped" data-tooltip="@lang('users.status'): {{ $recipe->getStatusText() }}">
                            <i class="fas {{ $recipe->getStatusIcon() }} circle p-1" style="color:{{ $recipe->getStatusColor() }};border:solid 2px {{ $recipe->getStatusColor() }};"></i>
                        </span>
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