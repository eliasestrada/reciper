@extends('layouts.app')

@section('title', trans('includes.my_recipes'))

@section('content')

{{-- Add recipe button --}}
@component('comps.btns.fixed-btn')
    @slot('icon') add @endslot
    @slot('class') modal-trigger @endslot
    @slot('link') #modal2 @endslot
    @slot('tip') @lang('includes.new_recipe') @endslot
@endcomponent

<div class="page">
    <div class="center">
        <h1 class="headline">@lang('includes.my_recipes')</h1>
    </div>

    <ul class="tabs"> {{-- Tab 2 --}}
        <li class="tab">
            <a href="#tab-1" class="active">
                @lang('messages.published') 
                <span class="red-text">({{ $recipes_ready->count() }})</span>
            </a> 
        </li>
        <li class="tab"> {{-- Tab 2 --}}
            <a href="#tab-2">
                @lang('messages.drafts') 
                <span class="red-text">({{ $recipes_unready->count() }})</span>
            </a>
        </li>
    </ul>

    @for ($i = 1; $i <= 2; $i++)
        @listOfRecipes([
            'recipes' => $i == 1 ? $recipes_ready : $recipes_unready,
            'class' => 'paper-dark',
            'id' => "tab-{$i}"
        ])
            @slot('no_recipes')
                @lang('users.no_recipes_yet')
                @include('includes.buttons.btn', [
                    'title' => trans('includes.add_recipe'),
                    'icon' => 'add',
                    'link' => '/recipes/create'
                ])
            @endslot
        @endlistOfRecipes
    @endfor
</div>

@endsection

@section('script')
    @include('includes.js.tabs')
@endsection