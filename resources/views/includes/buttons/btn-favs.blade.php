@auth
    <form action="{{ action('FavsController@store') }}" method="post" class="d-inline-block">
        @csrf <input type="hidden" name="recipe_id" value="{{ $recipe->id }}">
        <button type="submit" class="p-0" style="background:none;border:none;" title="{{ user()->hasFav($recipe->id) ? trans('recipes.remove_from_favs') : trans('recipes.add_to_favs') }}">
            <i class="fas fa-star fa-15x star p-1 {{ user()->hasFav($recipe->id) ? 'active' : '' }}"></i>
        </button>
    </form>
@else
    <a href="/login" title="@lang('forms.login')">
        <i class="fas fa-star fa-15x star"></i>
    </a>
@endauth