@auth
    <btn-favs
        recipe-id="{{ $recipe->id }}"
        :favs="{{ auth()->check() ? user()->favs->pluck('recipe_id') : 'null' }}">
    </btn-favs>
@else
    <a href="/login" title="@lang('auth.enter')" class="p-0">
        <i class="fas fa-star fa-15x star"></i>
    </a>
@endauth