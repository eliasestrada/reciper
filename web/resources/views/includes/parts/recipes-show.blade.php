<div class="center"><h1 style="font-size:2em">{{ $recipe->getTitle() }}</h1></div>

<div class="single-recipe__img-wrapper frames">
    <div class="placeholder-image"
        style="padding-bottom:67%; border-radius:4px; {{ setRandomBgColor() }}"
    ></div>
    <img src="{{ asset('storage/big/recipes/'.$recipe->image) }}"
        alt="{{ $recipe->getTitle() }}"
        class="single-recipe__img-wrapper__img z-depth-1 not-printable lazy-load-img"
    >
</div>

{{--  Category  --}}
<div class="center py-2 font-scalable" style="font-size:1.0em">
    @foreach ($recipe->categories as $category)
        <a href="/recipes#category={{ $category->id }}" title="{{ $category->getName() }}">
            <span class="new badge p-1 px-2 mx-1 float-none">{{ $category->getName() }}</span>
        </a>
    @endforeach
</div>

{{--  Time  --}}
<div class="my-3 font-scalable" style="font-size:{{ $cookie }}em">
    <i class="fas fa-clock fa-15x z-depth-2 circle red-text mr-2 tooltipped" data-tooltip="@lang('tips.recipes_time')"></i>
    {{ $recipe->time }} @lang('recipes.min').
</div>

{{-- Increase Font-Size --}}
<div class="min-w mt-2 not-printable" style="opacity:.7">
    <i class="fas fa-plus fa-1x mr-2"></i>
    <button type="button" class="hoverable waves-effect waves-green btn-floating btn-small green d-inline-block m-0 p-0" id="inc-font-size">
        <i class="fas fa-font fa-1x"></i>
    </button>
    <button type="button" class="hoverable waves-effect waves-red btn-floating btn-small d-inline-block red m-0 p-0" id="dic-font-size">
        <i class="fas fa-font fa-1x"></i>
    </button>
    <i class="fas fa-minus fa-1x ml-2"></i>
</div>

{{--  Intro  --}}
<blockquote class="left-align font-scalable" style="font-size:{{ $cookie }}em">
    {{ $recipe->getIntro() }}
</blockquote>

<div class="divider my-4"></div>

{{--  Items --}}
<div class="frames single-recipe__items py-4 px-3 z-depth-1 font-scalable" style="font-size:{{ $cookie }}em">
    <ul class="m-0">
        @include('includes.vue-preloader')
        @foreach ($recipe->ingredientsWithListItems() as $item)
            <list-item class-names="m-1 btn-small" v-cloak>
                <i slot="icon-on" class="fas fa-check-square fa-2x green-text"></i>
                <i slot="icon-off" class="fas fa-square fa-15x main-text"></i>
                <span slot="item">{!! $item !!}</span>
            </list-item>
        @endforeach
    </ul>

    {{-- File downloader --}}
    <div class="px-3 pt-4">
        <form method="post" action="{{ action('Invokes\DownloadIngredientsController', ['id' => $recipe->id]) }}">
            @csrf
            <button type="submit"
                class="btn-small not-printable confirm"
                data-confirm="@lang('recipes.are_you_sure_to_download')"
            >
                @lang('recipes.download_ingredients')
            </button>
        </form>
    </div>
</div>

{{--  Text  --}}
<blockquote class="pt-3 font-scalable" style="border:none; font-size:{{ $cookie }}em">
    <ul class="single-recipe__instruction unstyled-list">
        @include('includes.vue-preloader')

        @foreach ($recipe->textWithListItems() as $item)
            <list-item class-names="m-3" v-cloak>
                <i slot="icon-on" class="fas fa-check-square fa-2x green-text"></i>
                <i slot="icon-off" class="main-text bold-text">{{ $loop->iteration }}</i>
                <span slot="item">{!! $item !!}</span>
            </list-item>
        @endforeach
    </ul>
</blockquote>

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
        <a href="/users/{{ $recipe->user->username }}"
            title="@lang('recipes.search_by_author')"
            class="grey-text"
        >
            @lang('recipes.author'):
            <span class="red-text">{{ optional($recipe->user)->getName() }}</span>
        </a>
    </li>
</ul>
