@extends('layouts.app')

@section('title', trans('includes.my_recipes'))

@section('content')

{{-- Add recipe button --}}
@component('comps.btns.fixed-btn')
    @slot('icon') fa-plus @endslot
    @slot('class') modal-trigger @endslot
    @slot('link') #add-recipe-modal @endslot
    @slot('tip') @lang('includes.new_recipe') @endslot
@endcomponent

<div class="page">
    <div class="center">
        <h1 class="headline">@lang('includes.my_recipes')</h1>
    </div>

    <div v-cloak>
        <tabs>
            <tab name="@lang('messages.published')" :selected="true">
                @listOfRecipes([
                    'recipes' => $recipes_ready,
                    'class' => 'paper-dark',
                ])
                    @slot('no_recipes')
                        @lang('users.no_recipes_yet')
                        @include('includes.buttons.btn', [
                            'title' => trans('includes.add_recipe'),
                            'icon' => 'fa-plus',
                            'class' => 'modal-trigger',
                            'link' => '#add-recipe-modal'
                        ])
                    @endslot
                @endlistOfRecipes
            </tab>
            <tab name="@lang('messages.drafts')">
                @listOfRecipes([
                    'recipes' => $recipes_unready,
                    'class' => 'paper-dark',
                ])
                    @slot('no_recipes')
                        @lang('users.no_recipes_yet')
                        @include('includes.buttons.btn', [
                            'title' => trans('includes.add_recipe'),
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