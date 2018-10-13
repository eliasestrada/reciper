@extends('layouts.app')

@section('title', trans('admin.statistics'))

@section('content')

<div class="page row">
    <div class="center">
        <h1 class="headline"><i class="fas fa-chart-bar red-text"></i> @lang('admin.statistics')</h1>
    </div>

    <div class="col s12 m12 l6">
        <div class="center mt-3"><h5 class="header">@lang('messages.general')</h5></div>
        <table class="responsive highlight">
            <tr>
                {{-- All recipes --}}
                <td>@lang('recipes.amount_of_recipes')</td>
                <td class="right-align">{{ user()->recipes->count() }}</td>
            </tr>
            <tr>
                {{-- All likes --}}
                <td>@lang('users.amount_of_likes')</td>
                <td class="right-align">{{ $recipes->sum('likes_count') }} <i class='fas fa-heart tiny red-text'></i></td>
            </tr>
            <tr>
                {{-- All views --}}
                <td>@lang('users.amount_of_views')</td>
                <td class="right-align">{{ $recipes->sum('views_count') }} <i class='fas fa-eye tiny grey-text'></i></td>
            </tr>
            <tr>
                {{-- All favs --}}
                <td>@lang('users.amount_of_favs')</td>
                <td class="right-align">{{ $recipes->sum('favs_count') }} <i class='fas fa-star tiny' style="color:#d49d10"></td>
            </tr>
        </table>
    </div>

    <div class="col s12 m12 l6">
        <div class="center mt-4"><h5 class="header">@lang('users.reciper')</h5></div>
        <table class="responsive highlight">
            <tr>
                {{-- Exp points --}}
                <td>@lang('users.exp_of_reciper')</td>
                <td class="right-align">{{ user()->xp }}</td>
            </tr>
            <tr>
                {{-- Popularity points --}}
                <td>@lang('users.popularity_of_reciper')</td>
                <td class="right-align">{{ user()->popularity }}</td>
            </tr>
        </table>
    </div>

    <div class="col s12">
        <div class="center mt-4"><h5 class="header">@lang('recipes.recipes')</h5></div>
        <table class="responsive highlight">
            <tr>
                {{-- Loved recipe --}}
                <td>@lang('users.most_liked_recipe')</td>
                <td class="right-align">
                    @if ($most_liked)
                        <a href="{{ "/recipes/$most_liked->id" }}">{{ $most_liked->getTitle() }}</a>
                        {{ $most_liked->likes_count }} <i class='fas fa-heart red-text tiny'></i>
                    @else - @endif
                </td>
            </tr>
            <tr>
                {{-- Viewed recipe --}}
                <td>@lang('users.most_viewed_recipe')</td>
                <td class="right-align">
                    @if ($most_viewed)
                        <a href="{{ "/recipes/$most_viewed->id" }}">
                            {{ $most_viewed->getTitle() }}
                        </a>
                        {{ $most_viewed->views_count }} <i class='fas fa-eye grey-text tiny'></i>
                    @else - @endif
                </td>
            </tr>
            <tr>
                {{-- Favorite recipe --}}
                <td>@lang('users.most_favorite_recipe')</td>
                <td class="right-align">
                    @if ($most_liked)
                        <a href="{{ "/recipes/$most_favs->id" }}">{{ $most_favs->getTitle() }}</a>
                        {{ $most_favs->favs_count }} <i class='fas fa-star tiny' style="color:#d49d10"></i>
                    @else - @endif
                </td>
            </tr>
        </table>
    </div>
    <div class="col s12">
        <statistics-chart>
            <div class="valign-wrapper mt-4 center" style="height:273px">
                @include('includes.preloader')
            </div>
        </statistics-chart>
    </div>
</div>

@endsection