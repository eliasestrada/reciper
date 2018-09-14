@extends('layouts.app')

@section('title', trans('includes.checklist'))

@section('content')

@hasRole('admin')
    <div class="page">
        <div class="center">
            <h1 class="headline">
                @lang('includes.checklist') {{ count($unapproved) > 0 ? ': '.count($unapproved) : '' }}
            </h1>
        </div>

        @listOfRecipes(['recipes' => $unapproved])
            @slot('no_recipes')
                @lang('admin.no_unapproved')
            @endslot
        @endlistOfRecipes
    </div>
@endhasRole

@endsection