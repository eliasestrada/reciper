@extends('layouts.app')

@section('title', $recipe->getTitle())

@section('content')

<section class="grid-recipe pt-3">
    <div class="recipe-content center position-relative">

        {{-- Show menu button --}}
        <a href="#" title="@lang('recipes.show_menu')">
            <i class="material-icons small main-text right mr-5" id="popup-window-trigger">more_vert</i>
        </a>

        <div class="popup-window z-depth-2 p-3 position-absolute paper" id="popup-window">
            {{-- Report button --}}
            <a href="#report-recipe-modal" class="btn modal-trigger min-w"{{ visitor_id() == $recipe->user_id ? ' disabled' : '' }}>
                @lang('recipes.report_recipe')
            </a>

            {{--  To drafts button  --}}
            @if (optional(user())->hasRecipe($recipe->id) && $recipe->isReady() && $recipe->isApproved())
                <form action="{{ action('RecipesController@update', ['recipe' => $recipe->id]) }}" method="post" onsubmit="return confirm('@lang('recipes.are_you_sure_to_draft')');">
                    @method('put')
                    @csrf
                    <button class="btn min-w" id="_to_drafts">@lang('tips.add_to_drafts')</button>
                </form>
            @endif
            {{-- Edit button --}}
            <a href="/recipes/{{ $recipe->id }}/edit" class="btn min-w" {{ $recipe->isReady() ? 'disabled' : '' }}>
                @lang('tips.edit')
            </a>
        </div>

        {{--  Likes  --}}
        <div class="like-for-author-section">
            <a href="/users/{{ $recipe->user->id }}" class="user-icon-on-single-recipe" style="background:#484074 url({{ asset('storage/users/' . $recipe->user->image) }})" title="@lang('recipes.search_by_author')"></a>

            @if ($recipe->isDone())
                <like likes="{{ count($recipe->likes) }}" recipe-id="{{ $recipe->id }}">
                    @include('includes.icons.like-btn')
                </like>
            @endif
        </div>

        @include('includes.parts.recipes-show')
    </div>

    {{-- API: Еще рецепты Sidebar --}}
    <div class="side-bar center">
        <h6 class="decorated pb-3">@lang('recipes.more')</h6>
        <random-recipes-sidebar visitor-id="{{ visitor_id() }}">
            @include('includes.preloader')
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
                    <input type="hidden" name="recipe" value="{{ $recipe->id }}">
                    <textarea name="message" minlength="{{ config('validation.contact_message_min') }}" id="message" class="materialize-textarea counter" data-length="{{ config('validation.contact_message_max') }}" required>{{ old('message') }}</textarea>
                    <label for="message">@lang('form.message')</label>
                </div>
                <button type="submit" class="btn">@lang('form.send')</button>
            </form>
        </div>
    </div>
@endif

@endsection
