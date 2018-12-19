@extends('layouts.auth')

@section('title', trans('recipes.my_recipes'))

@section('content')

{{-- Add recipe button --}}
@component('comps.btns.fixed-btn')
    @slot('icon') fa-plus @endslot
    @slot('class') modal-trigger @endslot
    @slot('link') #add-recipe-modal @endslot
    @slot('tip') @lang('recipes.new_recipe') @endslot
@endcomponent

<div class="page">
    <div class="center mb-2">
        <h1 class="header"><i class="fas fa-book-open red-text"></i> @lang('recipes.my_recipes')</h1>
    </div>

    <div v-cloak>
        <tabs>
            <tab name="@lang('messages.published') <span class='red-text'><b>{{ $recipes_ready->count() }}</b></span>" :selected="true">
                @listOfRecipes(['recipes' => $recipes_ready, 'class' => 'paper-dark'])
                    @slot('no_recipes')
                        @lang('users.no_recipes_yet')
                        @include('includes.buttons.btn', [
                            'title' => trans('recipes.add_recipe'),
                            'icon' => 'fa-plus',
                            'class' => 'modal-trigger',
                            'link' => '#add-recipe-modal'
                        ])
                    @endslot
                @endlistOfRecipes
            </tab>
            <tab name="@lang('messages.drafts') <span class='red-text'><b>{{ $recipes_unready->count() }}</b></span>">
                @listOfRecipes(['recipes' => $recipes_unready, 'class' => 'paper-dark', 'edit' => true])
                    @slot('no_recipes')
                        @lang('users.no_recipes_yet')
                        @include('includes.buttons.btn', [
                            'title' => trans('recipes.add_recipe'),
                            'icon' => 'fa-plus',
                            'class' => 'modal-trigger',
                            'link' => '#add-recipe-modal'
                        ])
                    @endslot
                @endlistOfRecipes
            </tab>
        </tabs>
    </div>
</div>

@endsection
