<div class="center">
    <h5>{{ $recipe->getTitle() }}</h5>
</div>

<img src="{{ asset('storage/recipes/'.$recipe->image) }}" alt="{{ $recipe->getTitle() }}" class="recipe-img corner z-depth-1">

{{--  Category  --}}
<div class="center py-2">
    @foreach ($recipe->categories as $category)
        <a href="/recipes#category={{ $category->id }}" title="{{ $category->getName() }}">
            <span class="new badge p-1 px-2 float-none">{{ $category->getName() }}</span>
        </a>
    @endforeach
</div>

{{--  Time  --}}
<div class="my-3">
    <i class="fas fa-clock fa-15x z-depth-2 circle red-text mr-1 tooltipped" data-tooltip="@lang('tips.recipes_time')"></i>
    {{ $recipe->time }} @lang('recipes.min').
</div>

{{--  Intro  --}}
<blockquote class="left-align">
    {{ $recipe->getIntro() }}
</blockquote>

<div class="divider my-4"></div>

{{--  Items --}}
<div class="corner items py-4 px-3 z-depth-1">
    <ol class="m-0">
        @foreach ($recipe->ingredientsWithListItems() as $item)
            {!! $item !!}
        @endforeach
    </ol>
    {{-- File downloader --}}
    <div class="px-3 pt-4">
        <form action="{{ action('Invokes\DownloadIngredientsController', ['id' => $recipe->id]) }}" method="post">
            @csrf
            <button type="submit" class="btn-small">
                <i class="fas fa-download left"></i>
                @lang('recipes.ingredients')
            </button>
        </form>
    </div>
</div>

{{--  Text  --}}
<blockquote class="pt-3" style="border:none">
    <ol class="instruction unstyled-list">
        @foreach ($recipe->textWithListItems() as $item)
            {!! $item !!}
        @endforeach
    </ol>
</blockquote>

<div class="divider"></div>
<h5 class="decorated pt-3">@lang('recipes.bon_appetit')!</h5>

{{--  Date, views, author --}}
<ul class="mt-4 grey-text">
    <li>
        @lang('users.views'): 
        <span class="red-text">{{ $recipe->views->count() }}</span>
    </li>
    <li>
        @lang('recipes.added') 
        <span class="red-text">{{ time_ago($recipe->created_at) }}</span>
    </li>
    <li>
        <a href="/users/{{ $recipe->user->username }}" title="@lang('recipes.search_by_author')" class="grey-text">
            @lang('recipes.author'): 
            <span class="red-text">{{ optional($recipe->user)->getName() }}</span>
        </a>
    </li>
</ul>