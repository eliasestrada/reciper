@extends('layouts.app')

@section('title', $recipe->getTitle())

@section('content')

<section class="grid-recipe pt-3">
    <div class="recipe-content center position-relative">
        {{-- Edit button --}}
        @if (!$recipe->isReady())
            @component('comps.btns.fixed-btn')
                @slot('icon') fa-pen @endslot
                @slot('link') /recipes/{{ $recipe->id }}/edit @endslot
                @slot('tip') @lang('tips.edit') @endslot
            @endcomponent
        @endif

        {{-- Show menu button --}}
        <a href="#" title="@lang('recipes.show_menu')">
            <i class="fas fa-ellipsis-v fa-15x main-text right" id="popup-window-trigger" style="transform:translateX(-15px)"></i>
        </a>

        <div class="popup-window z-depth-2 p-3 position-absolute paper" id="popup-window">
            {{-- Report button --}}
            <a href="#report-recipe-modal" class="btn waves-effect waves-light modal-trigger min-w"{{ visitor_id() == $recipe->user_id || optional(user())->hasRecipe($recipe->id) ? ' disabled' : '' }}>
                @lang('recipes.report_recipe')
            </a>

            {{--  To drafts button  --}}
            @if (optional(user())->hasRecipe($recipe->id) && $recipe->isDone())
                <form action="{{ action('RecipesController@update', ['recipe' => $recipe->id]) }}" method="post">
                    @method('put')
                    @csrf
                    <button class="btn min-w" id="_to_drafts" onclick="if (!confirm('@lang('recipes.are_you_sure_to_draft')')) event.preventDefault()">@lang('tips.add_to_drafts')</button>
                </form>
            @endif
            {{-- Edit button --}}
            @if (optional(user())->hasRecipe($recipe->id))
                <a href="/recipes/{{ $recipe->id }}/edit" class="btn mt-2 min-w" {{ $recipe->isReady() ? 'disabled' : '' }}>
                    @lang('tips.edit')
                </a>
            @endif
        </div>

        {{--  Likes  --}}
        <div class="like-for-author-section noselect position-relative">
            @auth
                <form action="{{ action('FavsController@store') }}" method="post" class="d-inline-block" onsubmit="$('audio').volume = 0.2; $('audio').play()">
                    @csrf <input type="hidden" name="recipe_id" value="{{ $recipe->id }}">
                    <button type="submit" class="p-0" style="background:none;border:none;">
                        <i class="fas fa-star fa-15x star p-1 {{ user()->hasFav($recipe->id) ? 'active' : '' }}"></i>
                    </button>
                </form>
            @else
                <div class="position-absolute hide" style="left:20%;top:107%;z-index:5;" id="register-btns">
                    <a href="/login" class="btn-small hoverable waves-effect waves-light">@lang('forms.login')</a>
                    <a href="/register" class="btn-small hoverable waves-effect waves-light">@lang('forms.register')</a>
                </div>
                <i class="fas fa-star fa-15x star" id="show-register-btns"></i>
            @endauth
            <i>{{ $recipe->favs->count() }}</i>

            <a href="/users/{{ $recipe->user->id }}" class="user-icon-on-single-recipe z-depth-1 hoverable" style="background:#484074 url({{ asset('storage/users/' . $recipe->user->image) }})" title="@lang('recipes.search_by_author')"></a>

            @if ($recipe->isDone())
                <like likes="{{ count($recipe->likes) }}" recipe-id="{{ $recipe->id }}" inline-template>
                    <span>
                        <a href="#" v-on:click="toggleButton()" class="like-icon" :class="iconState()">
                            <div class="btn-wrapper">
                                <span class="btn-like">@include('includes.icons.like-btn')</span>
                            </div>
                        </a>
                        <audio ref="audio" id="audio" src="/storage/audio/like-effect.mp3" type="audio/mpeg"></audio>
                        <i id="_all-likes" v-text="allLikes"></i>
                    </span>
                </like>
            @endif
        </div>

        @include('includes.parts.recipes-show')
    </div>

    {{-- API: Еще рецепты Sidebar --}}
    <div class="side-bar center">
        <h6 class="decorated pb-3">@lang('recipes.more')</h6>
        <random-recipes-sidebar visitor-id="{{ visitor_id() }}" inline-template>
            <div>
                <div class="card hoverable" style="animation:appearWithRotate 1s;"
                    v-for="recipe in recipes"
                    :key="recipe.id">

                    <div class="card-image">
                        <a :href="'/recipes/' + recipe.id" :title="recipe.title" class="waves-effect waves-light">
                            <img :src="'/storage/images/' + recipe.image" :alt="recipe.title">
                        </a>
                    </div>
                    <div class="card-content p-3" v-text="recipe.title">@include('includes.preloader')</div>
                </div>
            </div>
        </random-recipes-sidebar>
    </div>
</section>


<!-- report-recipe-modal structure -->
@if (visitor_id() != $recipe->user_id)
    <div id="report-recipe-modal" class="modal">
        <div class="modal-content reset">
            <form action="{{ action('Admin\FeedbackController@store') }}" method="post">
                @csrf

                <h5>@lang('recipes.report_recipe')</h5>
                <p>@lang('feedback.report_message_desc')</p>

                <div class="input-field mt-4">
                    <input type="hidden" name="recipe_id" value="{{ $recipe->id }}">
                    <textarea name="message" minlength="{{ config('validation.feedback.contact.message.min') }}" id="message" class="materialize-textarea counter" data-length="{{ config('validation.feedback.contact.message.max') }}" required>{{ old('message') }}</textarea>
                    <label for="message">@lang('forms.message')</label>
                </div>
                <button type="submit" class="btn">@lang('forms.send')</button>
            </form>
        </div>
    </div>
@endif

@endsection
