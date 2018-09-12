@extends('layouts.app')

@section('title', $recipe->getTitle())

@section('content')

<section class="grid-recipe pt-3">
    <div class="recipe-content center">

        {{--  Likes  --}}
        <div class="like-for-author-section">
            <a href="/users/{{ $recipe->user->id }}" class="user-icon-on-single-recipe" style="background:#484074 url({{ asset('storage/users/' . $recipe->user->image) }})" title="@lang('recipes.search_by_author')"></a>

            @if ($recipe->isDone())
                <like likes="{{ count($recipe->likes) }}" recipe-id="{{ $recipe->id }}">
                    @include('includes.icons.like-btn')
                </like>
            @endif
        </div>

        @auth {{--  Buttons  --}}
            @if (user()->hasRecipe($recipe->id))
                <div class="center py-3 _action-buttons">
                    {{--  Edit button  --}}
                    <a href="/recipes/{{ $recipe->id }}/edit" class="btn-floating green tooltipped" data-tooltip="@lang('tips.edit')" data-position="top" id="_edit">
                        <i class="large material-icons">mode_edit</i>
                    </a>

                    {{--  Delete button  --}}
                    <delete-recipe-btn
                        recipe-id="{{ $recipe->id }}"
                        deleted-fail="{{ trans('recipes.deleted_fail') }}"
                        delete-recipe-tip="{{ trans('tips.delete') }}"
                        confirm="{{ trans('recipes.are_you_sure_to_delete') }}">
                    </delete-recipe-btn>
                </div>
            @endif
        @endauth

        @hasRole('admin')
            @if (!$recipe->isDone() && user()->id !== $recipe->user_id)
                <div class="py-2">
                    <p>@lang('recipes.approve_or_not')</p>

                    {{-- Approve --}}
                    <form action="{{ action('ApproveController@ok', ['recipe' => $recipe->id]) }}" method="post" class="d-inline-block" onsubmit="return confirm('@lang('recipes.are_you_sure_to_publish')')">
                        @csrf
                        <input type="hidden" name="message" id="output-message1">
                        <button class="btn green" type="submit">
                            @lang('messages.yes')
                            <i class="material-icons right">thumb_up</i>
                        </button>
                    </form>

                    {{-- Cancel --}}
                    <form action="{{ action('ApproveController@cancel', ['recipe' => $recipe->id]) }}" method="post" class="d-inline-block" onsubmit="return confirm('@lang('recipes.are_you_sure_to_cancel')')">
                        @csrf
                        <input type="hidden" name="message" id="output-message2">
                        <button class="btn red" type="submit">
                            @lang('messages.no')
                            <i class="material-icons right">thumb_down</i>
                        </button>
                    </form>
                </div>
                <div class="input-field">
                    <textarea id="input-message" class="materialize-textarea counter" data-length="{{ config('validation.approve_message') }}"></textarea>
                    <label for="textarea1">* @lang('notifications.set_message')</label>
                </div>
            @endif
        @endhasRole

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
            <i class="material-icons">timer</i>
            {{ $recipe->time }} @lang('recipes.min').
        </div>

        {{--  Intro  --}}
        <blockquote class="left-align">
            {{ $recipe->getIntro() }}
        </blockquote>

        <hr />

        {{--  Items --}}
        <blockquote class="items">
            <h5 class="decorated">@lang('recipes.ingredients')</h5>
            @foreach ($recipe->ingredientsWithListItems() as $item)
                <ol>{!! $item !!}</ol>
            @endforeach
        </blockquote>

        <hr />

        {{--  Text  --}}
        <blockquote style="border:none;">
            <h5 class="decorated py-3">@lang('recipes.text_of_recipe')</h5>
            @foreach ($recipe->textWithListItems() as $item)
                <ol class="instruction unstyled-list">{!! $item !!}</ol>
            @endforeach
        </blockquote>
        
        <hr />
        <h5 class="decorated pt-3">@lang('recipes.bon_appetit')!</h5>

        {{--  Date, views, author --}}
        <ul class="mt-4 grey-text">
            <li>
                @lang('users.views'): 
                <red>{{ $recipe->views->count() }}</red>
            </li>
            <li>
                @lang('recipes.added') 
                <red>{{ time_ago($recipe->created_at) }}</red>
            </li>
            <li>
                <a href="/users/{{ $recipe->user->id }}" title="@lang('recipes.search_by_author')" class="grey-text">
                    @lang('recipes.author'): 
                    <red>{{ optional($recipe->user)->name }}</red>
                </a>
            </li>
        </ul>
    </div>

    {{-- API: Еще рецепты Sidebar --}}
    <div class="side-bar center">
        <h6 class="decorated pb-3">@lang('recipes.more')</h6>
        <random-recipes-sidebar visitor-id="{{ visitor_id() }}">
            @include('includes.preloader')
        </random-recipes-sidebar>
    </div>
</section>

@endsection

@section('script')
    @include('includes.js.counter')
@endsection