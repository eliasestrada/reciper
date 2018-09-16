@extends('layouts.app')

@section('title', $recipe->getTitle())

@section('content')

<section class="grid-recipe pt-3">
    <div class="recipe-content center position-relative">

        {{-- Show menu button --}}
        <a href="#" title="@lang('recipes.show_menu')" id="popup-window-trigger">
            <i class="material-icons small main-text right mr-5">more_vert</i>
        </a>

        <div class="popup-window z-depth-2 p-3 position-absolute paper" id="popup-window">
            <a href="#report-recipe-modal" class="btn modal-trigger">
                @lang('recipes.report_recipe')
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

        @include('includes.recipe')
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

@endsection
