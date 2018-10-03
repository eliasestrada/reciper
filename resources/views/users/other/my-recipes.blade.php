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
    <div class="center mb-4">
        <h1 class="headline">@lang('includes.my_recipes')</h1>
    </div>

    <div v-cloak>
        <tabs>
            @for ($i = 1; $i <= 3; $i++)
                <tab 
                    @if ($i == 1)
                        name="@lang('messages.published') 
                        <span class='red-text'><b>{{ $recipes_ready->count() }}</b></span>"
                        :selected="true"
                    @elseif ($i == 2)
                        name="@lang('messages.drafts') 
                        <span class='red-text'><b>{{ $recipes_unready->count() }}</b></span>"
                    @elseif ($i == 3)
                        name="@lang('messages.favs') 
                        <span class='red-text'><b>{{ $favs->count() }}</b></span>"
                    @endif
                >
                    @listOfRecipes([
                        'recipes' => $i == 1 ? $recipes_ready : ($i == 2 ? $recipes_unready : $favs),
                        'class' => 'paper-dark',
                    ])
                        @slot('no_recipes')
                            @lang('users.no_recipes_yet')
                            @if ($i !== 3)
                                @include('includes.buttons.btn', [
                                    'title' => trans('includes.add_recipe'),
                                    'icon' => 'fa-plus',
                                    'class' => 'modal-trigger',
                                    'link' => '#add-recipe-modal'
                                ])
                            @endif
                        @endslot
                    @endlistOfRecipes
                </tab>
            @endfor
        </tabs>
    </div>
</div>

@endsection