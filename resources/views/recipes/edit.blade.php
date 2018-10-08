@extends('layouts.app')

@section('title', trans('recipes.add_recipe'))

@section('content')

<form action="{{ action('RecipesController@update', ['recipe' => $recipe->id]) }}" method="post" class="page" enctype="multipart/form-data" id="form-update-recipe">

    @method('put')
    @csrf

    <div class="row">
        <div class="center">
            <h1 class="headline pb-4">@lang('recipes.add_recipe')</h1>
        </div>

        <div class="center pb-4">
            {{--  View button  --}}
            <input type="submit" value="&#xf06e" name="view" class="fas btn-floating green tooltipped" data-tooltip="@lang('tips.view')">

            {{--  Save button  --}}
            <button type="submit" id="submit-save-recipe" data-tooltip="@lang('tips.save')" class="btn-floating green tooltipped waves-effect waves-light">
                <i class="fas fa-save"></i>
            </button>

            {{--  Delete button  --}}
            <delete-recipe-btn inline-template
                recipe-id="{{ $recipe->id }}"
                deleted-fail="{{ trans('recipes.deleted_fail') }}"
                confirm="{{ trans('recipes.are_you_sure_to_delete') }}">
                <span v-if="!error">
                    <button type="button" class="btn-floating red tooltipped waves-effect waves-light" id="_delete-recipe" data-position="top"
                        data-tooltip="@lang('tips.delete')"
                        v-on:click="deleteRecipe">
                            <i class="fas fa-trash"></i>
                    </button>
                </span>
            </delete-recipe-btn>

            {{--  Publish button  --}}
            <a href="#" class="btn-floating green tooltipped waves-effect waves-light" id="publish-btn" data-tooltip="@lang('tips.publish')" data-alert="@lang('recipes.are_you_sure_to_publish')">
                <i class="fas fa-clipboard-check"></i>
            </a>
            <input type="checkbox" name="ready" value="1" class="hide" id="ready-checkbox">
        </div>

        <div class="row">
            {{-- Title --}}
            <div class="col s12 m6 l4">
                <div class="input-field">
                    <input type="text" name="title" id="title" value="{{ old('title') ?? $recipe->getTitle() }}" class="counter" data-length="{{ config('valid.recipes.title.max') }}">
                    <label for="title">@lang('recipes.title')</label>
                </div>
            </div>

            {{-- Time --}}
            <div class="col s12 m6 l4">
                <div class="input-field">
                    <input type="number" name="time" id="time" value="{{ old('time') ?? $recipe->time }}">
                    <label for="time">@lang('recipes.time_desc')</label>
                </div>
            </div>

            {{-- Meal --}}
            <div class="col s12 m6 l4">
                <label for="meal">@lang('recipes.meal_desc')</label>
                <select name="meal" id="meal">
                    @foreach ($meal as $m)
                        <option value="{{ $m->id }}" {{ set_as_selected_if_equal($m->id, ($recipe->meal->id ?? '')) }}>
                            {{ title_case($m->getName()) }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            {{-- Ingredients --}}
            <div class="col s12 l6">
                <div class="input-field">
                    <textarea name="ingredients" id="ingredients" class="materialize-textarea counter" data-length="{{ config('valid.recipes.ingredients.max') }}">{{ old('ingredients') ?? $recipe->getIngredients() }}</textarea>

                    <label for="ingredients">
                        @lang('recipes.ingredients') 
                        @include('includes.tip', ['tip' => trans('tips.recipes_ingredients')])
                    </label>
                </div>
            </div>

            {{-- Intro --}}
            <div class="col s12 l6">
                <div class="input-field">
                    <textarea name="intro" id="intro" class="materialize-textarea counter" data-length="{{ config('valid.recipes.intro.max') }}">{{ old('intro') ?? $recipe->getIntro() }}</textarea>

                    <label for="intro">
                        @lang('recipes.short_intro') 
                        @include('includes.tip', ['tip' => trans('tips.recipes_intro')])
                    </label>
                </div>
            </div>
        </div>

        {{-- Text --}}
        <div class="col s12">
            <div class="input-field">
                <textarea name="text" id="text" class="materialize-textarea counter" data-length="{{ config('valid.recipes.text.max') }}">{{ old('text') ?? $recipe->getText() }}</textarea>

                <label for="text">
                    @lang('recipes.text_of_recipe') 
                    @include('includes.tip', ['tip' => trans('tips.recipes_text')])
                </label>
            </div>
        </div>

        {{-- Categories --}}
        <div class="row">
            <div class="col s12 m6">
                <categories-field
                    locale="{{ lang() }}"
                    :recipe-categories="{{ json_encode($recipe->categories->toArray()) }}"
                    label="@lang('recipes.category')"
                    select="@lang('forms.select')"
                    categories-title="@lang('recipes.categories_title')"
                    deleting="@lang('forms.deleting')"
                    add="@lang('forms.add')">
                    @include('includes.preloader')
                </categories-field>
            </div>

            {{-- Image --}}
            <div class="col s12 m6">
                <div class="center pb-5">
                    <h5 class="col s12 mb-3">@lang('recipes.image')</h5>
                    <div class="preview-image preview-image-recipe position-relative">
                        <img src="{{ asset("storage/images/$recipe->image") }}" alt="{{ $recipe->title }}" id="target-image">
                        <input type="file" name="image" id="src-image" class="hide" style="overflow:hidden">
                        <label for="src-image" class="btn waves-effect waves-light min-w">
                            <i class="fas fa-upload left"></i>
                            @lang('forms.select_file')
                        </label>
                        <div class="preview-overlay"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

@endsection
