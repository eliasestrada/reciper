<div class="center">
    <h1 class="decorated">{{ $recipe->getTitle() }}</h1>
</div>

<img src="{{ asset('storage/images/'.$recipe->image) }}" alt="{{ $recipe->getTitle() }}" class="recipe-img">

{{--  Category  --}}
<div class="center py-3">
    @foreach ($recipe->categories as $category)
        <a href="/recipes#category={{ $category->id }}" title="{{ $category->getName() }}">
            <span class="new badge p-1 px-2" style="float:none;">{{ $category->getName() }}</span>
        </a>
    @endforeach
</div>

{{--  Time  --}}
<div class="my-3">
    <i class="fas fa-clock fa-2x main-text"></i>
    {{ $recipe->time }} @lang('recipes.min').
</div>

{{--  Intro  --}}
<blockquote class="left-align">
    {{ $recipe->getIntro() }}
</blockquote>

<div class="divider my-4"></div>

{{--  Items --}}
<blockquote class="items">
    <h5 class="decorated">@lang('recipes.ingredients')</h5>
    <ol>
        @foreach ($recipe->ingredientsWithListItems() as $item)
            {!! $item !!}
        @endforeach
    </ol>
</blockquote>

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
        <a href="/users/{{ $recipe->user->id }}" title="@lang('recipes.search_by_author')" class="grey-text">
            @lang('recipes.author'): 
            <span class="red-text">{{ optional($recipe->user)->name }}</span>
        </a>
    </li>
</ul>