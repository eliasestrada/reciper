@extends('layouts.app')

@section('title', $user->name)

@section('content')

<div class="page profile-header">
    <div>
        <h1 class="my-4">{{ $user->name }}</h1>
        <p>@lang('users.joined'): {{ time_ago($user->created_at) }}</p>
        @unless (user() && $user->id === user()->id)
            <p>
                {!! get_online_icon(time_ago($user->online_at)) !!}
                @lang('date.online') 
                {{ time_ago($user->online_at, 'online') }}
            </p>
        @endunless
    </div>

    <div class="image-wrapper">
        <img src="{{ asset('storage/users/'.$user->image) }}" alt="{{ $user->name }}" />
    </div>

    <div class="bubbles">

        {{-- Likes Bubble --}}
        <div class="mb-4 bubbles-block">
            <div class="bubble">
                <span class="number">{!! readable_number($likes) !!}</span>
                @include('includes.icons.heart')
            </div>
            <span>@lang('users.likes')</span>
        </div>

        {{-- Rating Bubble --}}
        <div class="mb-4 bubbles-block">
            <div class="bubble">
                <span class="number">{!! readable_number($user->points) !!}</span>
                @include('includes.icons.trophy')
            </div>
            <span>@lang('users.rating')</span>
        </div>

        {{-- Views Bubble --}}
        <div class="bubbles-block">
            <div class="bubble">
                <span class="number">{!! readable_number($views) !!}</span>
                @include('includes.icons.eye')
            </div>
            <span>@lang('users.views')</span>
        </div>
    </div>
</div>

{{--  All my recipes  --}}
<div class="page">
    @listOfRecipes(['recipes' => $recipes])
        @slot('no_recipes')
            @lang('users.this_user_does_not_have_recipes')
        @endslot
    @endlistOfRecipes
</div>

@endsection