@extends('layouts.app')

@section('title', $user->name)

@section('content')

<div class="page profile-header">
    <div class="pb-3">
        <h1 class="header m-0">{{ $user->name }}</h1>

        {{-- Registered --}}
        <span class="d-block py-2 grey-dark-text">
            @lang('users.joined'): {{ time_ago($user->created_at) }}
        </span>

        {{-- Last visit --}}
        @unless ($user->id === optional(user())->id)
            <span class="d-block py-2">
                {!! get_online_icon(time_ago($user->updated_at)) !!}
                @lang('date.online') 
                {{ time_ago($user->updated_at, 'online') }}
            </span>
        @endunless
    </div>

    <div>
        <img src="{{ asset('storage/users/'.$user->image) }}" class="profile-image" alt="{{ $user->name }}" />
    </div>

    {{-- Visitor id --}}
    @if (optional(user())->hasRole('master'))
        <a href="/master/visitors/{{ $user->visitor_id }}" class="btn-small mt-3">
            @lang('visitors.visitor') #{{ $user->visitor_id }}
        </a>
    @endif

    <div class="bubbles">

        {{-- Likes Bubble --}}
        <div class="bubbles-block">
            <i class="fas fa-heart fa-2x tooltipped" data-tooltip="@lang('tips.likes_tip', ['value' => $recipes->sum('likes_count')])" data-position="top" style=""></i>
            <div class="bubble">
                <span class="number">{!! readable_number($recipes->sum('likes_count')) !!}</span>
            </div>
            <span>@lang('users.likes')</span>
        </div>

        {{-- Rating Bubble --}}
        <div class="bubbles-block">
            <i class="fas fa-award fa-2x tooltipped" data-tooltip="@lang('tips.rating_tip', ['value' => $user->exp])" data-position="top"></i>
            <div class="bubble">
                <span class="number">{!! readable_number($user->exp) !!}</span>
            </div>
            <span>@lang('users.exp')</span>
        </div>

        {{-- Views Bubble --}}
        <div class="bubbles-block">
            <i class="fas fa-eye fa-2x tooltipped" data-tooltip="@lang('tips.views_tip', ['value' => $recipes->sum('views_count')])" data-position="top"></i>
            <div class="bubble">
                <span class="number">{!! readable_number($recipes->sum('views_count')) !!}</span>
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