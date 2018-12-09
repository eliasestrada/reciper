@extends(auth()->check() ? 'layouts.auth' : 'layouts.guest')

@section('title', $user->getName())

@section('content')

<div class="page profile-header">
    @if ($user->isActive())
        <div class="row">
            <div class="col s12 l6">
                <div class="mt-2">
                    <div class="profile-image frames">
                        <div class="placeholder-image"
                            style="padding-bottom:100%; {{ setRandomBgColor() }}"
                        ></div>
                        <img src="{{ asset('storage/big/users/'.$user->photo) }}"
                            class="z-depth-1 hoverable lazy-load-img"
                            alt="{{ $user->getName() }}"
                        />
                    </div>

                    <div class="my-2">
                        {{-- Manage user --}}
                        @if (optional(user())->hasRole('master'))
                            <a href="/master/manage-users/{{ $user->id }}" class="mr-2" title="@lang('manage-users.manage')">
                                <i class="fas fa-cog red-text fa-15x"></i>
                            </a>
                        @endif
                        {{-- Streak days --}}
                        <div class="tooltipped d-inline-block" data-tooltip="@lang('users.streak_days')" style="animation:appearWithRotate .7s">
                            <i class="fas fa-fire fa-15x" style="color:orangered"></i> 
                            <b class="px-1">{{ $user->streak_days }}</b>
                        </div>
                        {{-- Stars --}}
                        <div class="tooltipped d-inline-block" data-tooltip="@lang('users.amount_of_favs')" style="animation:appearWithRotate 1.1s">
                            <i class="fas fa-star fa-15x" style="color:#d49d10"></i> 
                            <b class="px-1">{{ $recipes->sum('favs_count') }}</b>
                        </div>
                    </div>
                </div>

                <h1 class="header mb-2">{{ $user->getName() }}</h1>

                {{-- Last visit --}}
                @unless ($user->id === optional(user())->id)
                    <span class="d-block py-2">
                        {!! get_online_icon(time_ago($user->online_check)) !!}
                        @lang('date.online') 
                        {{ time_ago($user->online_check, 'online') }}
                    </span>
                @endunless

                {{-- Registered --}}
                <span class="d-block py-2 grey-text">
                    @lang('users.joined'): {{ time_ago($user->created_at) }}
                </span>
            </div>

            <div class="col s12 l6">
                <div class="bubbles no-select">
                    {{-- Likes Bubble --}}
                    <div class="bubbles-block" style="animation:appearWithRotate .3s">
                        <i class="fas fa-heart fa-2x"></i>
                        <div class="bubble" title="@lang('tips.likes_tip', ['value' => number_format($recipes->sum('likes_count'))])">
                            <span class="number">
                                {!! readable_number($recipes->sum('likes_count')) !!}
                            </span>
                        </div>
                        <span>@lang('users.likes')</span>
                    </div>

                    {{-- Popularity Bubble --}}
                    <div class="bubbles-block" style="animation:appearWithRotate .7s">
                        <i class="fas fa-crown fa-2x"></i>
                        <div class="bubble" title="@lang('tips.rating_tip', ['value' => $user->popularity])">
                            <span class="number">
                                {!! readable_number($user->popularity) !!}
                            </span>
                        </div>
                        <span>@lang('users.popularity')</span>
                    </div>

                    {{-- Views Bubble --}}
                    <div class="bubbles-block" style="animation:appearWithRotate 1s">
                        <i class="fas fa-eye fa-2x"></i>
                        <div class="bubble" title="@lang('tips.views_tip', ['value' => number_format($recipes->sum('views_count'))])">
                            <span class="number">
                                {!! readable_number($recipes->sum('views_count')) !!}
                            </span>
                        </div>
                        <span>@lang('users.views')</span>
                    </div>
                </div>

                {{-- Level bar --}}
                <div class="progress-wrap mt-4 z-depth-1 mb-2" data-xp="@lang('users.xp') {{ $user->xp }} {{ $xp->minXpForCurrentLevel() >= config('custom.max_xp') ? '' : '/ '. ($xp->maxXpForCurrentLevel() + 1) }}">
                    <div class="bar" style="width:{{ $xp->getPercent() }}%"></div>
                </div>

                {{-- Level Badge --}}
                <div class="badge-panel mb-3">
                    <h6 class="mr-3 d-inline-block">
                        @lang('users.reciper')
                    </h6>
                    <div class="level-badge-wrap mt-5 d-inline-block z-depth-2 hoverable {{ $xp->getColor() }}">
                        <div class="level-badge {{ $xp->getColor() }}">
                            <span>{{ $xp->getLevel() }}</span>
                        </div>
                    </div>
                    <h6 class="ml-3 d-inline-block">
                        @lang('users.level')
                    </h6>
                </div>

                @if ($user->status)
                    <div class="center pb-3 pt-2">
                        <h6>{{ $user->status }}</h6>
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
    @else
        <div class="center">
            <img src="{{ asset('storage/big/users/not_active.jpg') }}" class="profile-image frames z-depth-1 hoverable" alt="{{ $user->getName() }}" />
            <p>@lang('users.user_is_not_active')</p>
        </div>
    @endif
</div>

@endsection