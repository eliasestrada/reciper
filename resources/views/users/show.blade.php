@extends('layouts.app')

@section('title', $user->name)

@section('content')

<div class="page profile-header">
    <div class="row">
        <div class="col s12 l6">
            <div class="mt-2">
                <img src="{{ asset('storage/users/'.$user->image) }}" class="profile-image corner z-depth-1 hoverable" alt="{{ $user->name }}" />
            </div>

            <h1 class="header mt-4 mb-2">{{ $user->name }}</h1>

            {{-- Last visit --}}
            @unless ($user->id === optional(user())->id)
                <span class="d-block py-2">
                    {!! get_online_icon(time_ago($user->updated_at)) !!}
                    @lang('date.online') 
                    {{ time_ago($user->updated_at, 'online') }}
                </span>
            @endunless

            {{-- Registered --}}
            <span class="d-block py-2 grey-dark-text">
                @lang('users.joined'): {{ time_ago($user->created_at) }}
            </span>
        </div>

        <div class="col s12 l6">
            {{-- Visitor id --}}
            @if (optional(user())->hasRole('master'))
                <a href="/master/visitors/{{ $user->visitor_id }}" class="btn-small mt-3">
                    @lang('visitors.visitor') #{{ $user->visitor_id }}
                </a>
            @endif

            <div class="bubbles no-select">
                {{-- Likes Bubble --}}
                <div class="bubbles-block">
                    <i class="fas fa-heart fa-2x tooltipped" data-tooltip="@lang('tips.likes_tip', ['value' => number_format($recipes->sum('likes_count'))])" data-position="top"></i>
                    <div class="bubble">
                        <span class="number">{!! readable_number($recipes->sum('likes_count')) !!}</span>
                    </div>
                    <span>@lang('users.likes')</span>
                </div>

                {{-- Popularity Bubble --}}
                <div class="bubbles-block">
                    <i class="fas fa-crown fa-2x tooltipped" data-tooltip="@lang('tips.rating_tip', ['value' => $user->popularity])" data-position="top"></i>
                    <div class="bubble">
                        <span class="number">{!! readable_number($user->popularity) !!}</span>
                    </div>
                    <span>@lang('users.popularity')</span>
                </div>

                {{-- Views Bubble --}}
                <div class="bubbles-block">
                    <i class="fas fa-eye fa-2x tooltipped" data-tooltip="@lang('tips.views_tip', ['value' => number_format($recipes->sum('views_count'))])" data-position="top"></i>
                    <div class="bubble">
                        <span class="number">{!! readable_number($recipes->sum('views_count')) !!}</span>
                    </div>
                    <span>@lang('users.views')</span>
                </div>
            </div>

            {{-- Level bar --}}
            <div class="progress-wrap mt-4 z-depth-1" data-lvl="@lang('users.level') {{ $user->getLvl() }}" data-exp="{{ $user->exp - $user->getLvlMin() }} / {{ $user->getLvlMax() }}.0">
                <div class="bar" style="width:{{ ($user->exp - $user->getLvlMin()) * 100 / $user->getLvlMax() }}%"></div>
            </div>
            <span class="d-block mt-2">@lang('users.exp') <b class="red-text">{{ $user->exp }}</b></span>

            @if ($user->about_me)
                <div class="center pb-3 pt-4">
                    <h6 class="header">@lang('settings.about_me')</h6>
                    <h6>{{ $user->about_me }}</h6>
                </div>
            @endif
        </div>
    </div>

    <div class="divider"></div>

    {{--  All my recipes  --}}
    @listOfRecipes(['recipes' => $recipes])
        @slot('no_recipes')
            @lang('users.this_user_does_not_have_recipes')
        @endslot
    @endlistOfRecipes
</div>

@endsection