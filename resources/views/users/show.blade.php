@extends('layouts.app')

@section('title', $user->name)

@section('content')

<div class="page profile-header">
    <div class="pb-3">
        <h1 class="header m-0">{{ $user->name }}</h1>

        <span class="d-block py-2 grey-dark-text">
            @lang('users.joined'): {{ time_ago($user->created_at) }}
        </span>
        @unless ($user->id === optional(user())->id)
            <span class="d-block py-2">
                {!! get_online_icon(time_ago($user->updated_at)) !!}
                @lang('date.online') 
                {{ time_ago($user->updated_at, 'online') }}
            </span>
        @endunless
    </div>

    <div class="image-wrapper">
        <img src="{{ asset('storage/users/'.$user->image) }}" alt="{{ $user->name }}" />
    </div>

    <div class="bubbles">

        {{-- Likes Bubble --}}
        <div class="mb-4 bubbles-block">
            <div class="bubble">
                <span class="number">{!! readable_number($recipes->sum('likes_count')) !!}</span>
                @include('includes.icons.heart')
            </div>
            <span>@lang('users.likes')</span>
        </div>

        {{-- Rating Bubble --}}
        <div class="mb-4 bubbles-block">
            <div class="bubble">
                <span class="number">{!! readable_number($user->exp) !!}</span>
                @include('includes.icons.trophy')
            </div>
            <span>@lang('users.exp')</span>
        </div>

        {{-- Views Bubble --}}
        <div class="bubbles-block">
            <div class="bubble">
                <span class="number">{!! readable_number($recipes->sum('views_count')) !!}</span>
                @include('includes.icons.eye')
            </div>
            <span>@lang('users.views')</span>
        </div>
    </div>
</div>

<div class="divider mb-3"></div>

@if ($user->about_me)
    <div class="center pb-3">
        <h6 class="header">@lang('settings.about_me')</h6>
        <h6>{{ $user->about_me }}</h6>
    </div>
    <div class="divider"></div>
@endif

{{--  All my recipes  --}}
<div class="page">
    @listOfRecipes(['recipes' => $recipes])
        @slot('no_recipes')
            @lang('users.this_user_does_not_have_recipes')
        @endslot
    @endlistOfRecipes
</div>

@endsection