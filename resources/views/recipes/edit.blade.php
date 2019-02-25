@extends('layouts.auth')

@section('title', trans('recipes.add_recipe'))

@section('content')

<form action="{{ action('RecipeController@update', ['recipe' => $recipe->slug]) }}"
    method="post"
    class="page"
    id="submit-recipe-form"
    enctype="multipart/form-data"
>

    @method('put')
    @csrf

    <div class="row">
        <div class="center">
            <h1 class="header pb-4">@lang('recipes.add_recipe')</h1>
        </div>

        <div class="center pb-4">
            {{--  View button  --}}
            <input type="submit" value="&#xf06e" name="view"
                class="fas btn-floating green tooltipped"
                data-tooltip="@lang('tips.view')"
            >

            {{--  Save button  --}}
            <button type="submit" id="submit-save-recipe"
                data-tooltip="@lang('tips.save')"
                class="btn-floating green tooltipped waves-effect waves-light"
            >
                <i class="fas fa-save"></i>
            </button>

            {{--  Delete button  --}}
            <delete-recipe-btn inline-template
                recipe-id="{{ $recipe->id }}"
                deleted-fail="{{ trans('recipes.deleted_fail') }}"
                confirm="{{ trans('recipes.are_you_sure_to_delete') }}"
            >
                <span v-if="!error">
                    <a href="#" id="_delete-recipe"
                        class="btn-floating red tooltipped waves-effect waves-light"
                        data-tooltip="@lang('forms.deleting')"
                        v-on:click="deleteRecipe"
                        data-position="top"
                    >
                        <i class="fas fa-trash"></i>
                    </a>
                </span>
            </delete-recipe-btn>

            {{--  Publish button  --}}
            <a href="#"
                class="btn-floating green tooltipped waves-effect waves-light submit-form-btn"
                data-confirm="@lang('recipes.are_you_sure_to_publish')"
                data-tooltip="@lang('tips.publish')"
                data-checkbox="ready-checkbox"
                data-form="submit-recipe-form"
            >
                <i class="fas fa-clipboard-check"></i>
            </a>
            <input type="checkbox" name="ready" value="1" class="hide" id="ready-checkbox">
        </div>

        <div class="row">
            {{-- Title --}}
            <div class="col s12 m12 l6">
                <div class="input-field">
                    <input type="text" name="title"
                        value="{{ old('title') ?? $recipe->getTitle() }}"
                        data-length="{{ config('valid.recipes.title.max') }}"
                        class="counter"
                        id="title"
                    >
                    <label for="title">@lang('recipes.title')</label>
                    @include('includes.input-error', ['field' => 'title'])
                </div>
            </div>

            {{-- Time --}}
            <div class="col s12 m6 l3">
                <div class="input-field">
                    <label for="time">
                        @lang('recipes.time') 
                        @include('includes.tip', ['tip' => trans('tips.recipes_time')])
                    </label>
                    <input type="number" name="time" id="time" value="{{ old('time') ?? $recipe->time }}">
                    @include('includes.input-error', ['field' => 'time'])
                </div>
            </div>

            {{-- Meal --}}
            <div class="col s12 m6 l3">
                <label for="meal">
                    @lang('recipes.meal_desc') 
                    @include('includes.tip', ['tip' => trans('tips.recipes_meal')])
                </label>
                <select name="meal" id="meal">
                    @foreach ($meal as $m)
                        <option value="{{ $m['id'] }}"
                            {{ set_as_selected_if_equal($m['id'], ($recipe->meal->id ?? '')) }}
                        >
                            {{ title_case($m[_('name')]) }}
                        </option>
                    @endforeach
                </select>
                @include('includes.input-error', ['field' => 'meal'])
            </div>
        </div>

        <div class="row">
            {{-- Ingredients --}}
            <div class="col s12 l6">
                <div class="input-field">
                    <textarea name="ingredients" id="ingredients"
                        class="materialize-textarea counter textarea-lines"
                        data-length="{{ config('valid.recipes.ingredients.max') }}"
                    >{{ old('ingredients') ?? $recipe->getIngredients() }}</textarea>

                    <label for="ingredients">
                        @lang('recipes.ingredients') 
                        @include('includes.tip', ['tip' => trans('tips.recipes_ingredients')])
                    </label>
                    @include('includes.input-error', ['field' => 'ingredients'])
                </div>
            </div>

            {{-- Intro --}}
            <div class="col s12 l6">
                <div class="input-field">
                    <textarea name="intro" id="intro"
                        class="materialize-textarea counter"
                        data-length="{{ config('valid.recipes.intro.max') }}"
                    >{{ old('intro') ?? $recipe->getIntro() }}</textarea>

                    <label for="intro">
                        @lang('recipes.short_intro') 
                        @include('includes.tip', ['tip' => trans('tips.recipes_intro')])
                    </label>
                    @include('includes.input-error', ['field' => 'intro'])
                </div>
            </div>
        </div>

        {{-- Text --}}
        <div class="col s12">
            <div class="input-field">
                <textarea name="text" id="text"
                    class="materialize-textarea counter textarea-lines"
                    data-length="{{ config('valid.recipes.text.max') }}"
                >{{ old('text') ?? $recipe->getText() }}</textarea>

                <label for="text">
                    @lang('recipes.text_of_recipe') 
                    @include('includes.tip', ['tip' => trans('tips.recipes_text')])
                </label>
                @include('includes.input-error', ['field' => 'text'])
            </div>
        </div>

        {{-- Categories --}}
        <div class="row">
            <div class="col s12 m12 l6">
                <categories-field
                    :recipe-categories="{{ json_encode($recipe->categories->toArray()) }}"
                    :categories="{{ isset($categories) ? json_encode($categories) : [] }}"
                    label="@lang('recipes.category')"
                    select="@lang('forms.select')"
                    categories-title="@lang('recipes.categories_title')"
                    deleting="@lang('forms.deleting')"
                    add="@lang('forms.add')"
                >
                    @include('includes.preloader')
                </categories-field>

                @include('includes.input-error', ['field' => 'categories.*'])
            </div>

            {{-- Image --}}
            <div class="col s12 m12 l6">
                <div class="center pb-5">
                    <h5 class="col s12 mb-3">@lang('recipes.image')</h5>

                    @include('includes.input-error', ['field' => 'image'])

                    <div class="preview-image preview-image-recipe position-relative">
                        <img src="{{ asset("storage/big/recipes/{$recipe->image}") }}"
                            alt="{{ $recipe->title }}"
                            id="target-image"
                        >
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
