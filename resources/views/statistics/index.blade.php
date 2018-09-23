@extends('layouts.app')

@section('title', trans('admin.statistics'))

@section('content')

<div class="page">
    <div class="center">
        <h1 class="headline mb-3">@lang('admin.statistics')</h1>
    </div>
    
    <div class=" pb-5">
        <table class="mt-4 responsive highlight">
            <tr>
                <td scope="row">@lang('recipes.amount_of_recipes')</td>
                <td class="right-align">{{ user()->recipes->count() }}</td>
            </tr>
            <tr>
                <td scope="row">@lang('users.amount_of_likes')</td>
                <td class="right-align">{{ $recipes->sum('likes_count') }}</td>
            </tr>
            <tr>
                <td scope="row">@lang('users.amount_of_views')</td>
                <td class="right-align">{{ $recipes->sum('views_count') }}</td>
            </tr>
            <tr>
                <td scope="row">@lang('users.exp_of_reciper')</td>
                <td class="right-align">{{ user()->exp }}</td>
            </tr>
            <tr>
                <td scope="row">@lang('users.most_viewed_recipe')</td>
                <td class="right-align">{{ $most_viewed }}</td>
            </tr>
            <tr>
                <td scope="row">@lang('users.most_liked_recipe')</td>
                <td class="right-align">{{ $most_liked }}</td>
            </tr>
        </table>
    </div>
</div>

@endsection