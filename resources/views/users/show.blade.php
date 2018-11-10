@extends(auth()->check() ? 'layouts.auth' : 'layouts.guest')

@section('title', $user->getName())

@section('content')

<div class="page profile-header">
    @if ($user->isActive())
        <div class="row">
            <div class="col s12 l6">
                <div class="mt-2">
                    <img src="{{ asset('storage/users/'.$user->photo) }}" class="profile-image corner z-depth-1 hoverable" alt="{{ $user->getName() }}" />

                    <div class="my-2">
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
                        <div class="bubble">
                            <span class="number tooltipped" data-tooltip="@lang('tips.likes_tip', ['value' => number_format($recipes->sum('likes_count'))])">
                                {!! readable_number($recipes->sum('likes_count')) !!}
                            </span>
                        </div>
                        <span>@lang('users.likes')</span>
                    </div>

                    {{-- Popularity Bubble --}}
                    <div class="bubbles-block" style="animation:appearWithRotate .7s">
                        <i class="fas fa-crown fa-2x"></i>
                        <div class="bubble">
                            <span class="number tooltipped" data-tooltip="@lang('tips.rating_tip', ['value' => $user->popularity])">
                                {!! readable_number($user->popularity) !!}
                            </span>
                        </div>
                        <span>@lang('users.popularity')</span>
                    </div>

                    {{-- Views Bubble --}}
                    <div class="bubbles-block" style="animation:appearWithRotate 1s">
                        <i class="fas fa-eye fa-2x"></i>
                        <div class="bubble">
                            <span class="number tooltipped" data-tooltip="@lang('tips.views_tip', ['value' => number_format($recipes->sum('views_count'))])">
                                {!! readable_number($recipes->sum('views_count')) !!}
                            </span>
                        </div>
                        <span>@lang('users.views')</span>
                    </div>
                </div>
                
                {{-- Level bar --}}
                <div class="progress-wrap mt-4 z-depth-1 mb-2" data-lvl="@lang('users.level') {{ $xp->getLevel() }}" data-xp="@lang('users.xp') {{ $user->xp }} {{ $xp->minXpForCurrentLevel() >= config('custom.max_xp') ? '' : '/ '. ($xp->maxXpForCurrentLevel() + 1) }}">
                    <div class="bar" style="width:{{ $xp->getPercent() }}%"></div>
                </div>

                {{-- Level badge --}}
                <div class="level-badge-wrap d-inline-block mt-4 z-depth-2 hoverable {{ $xp->getColor() }}">
                    <div class="level-badge {{ $xp->getColor() }}">
                        <span>{{ $xp->getLevel() }}</span>
                    </div>
                </div>

                @if ($user->status)
                    <div class="center pb-3 pt-4">
                        <h6>{{ $user->status }}</h6>
                    </div>
                @endif
            </div>

            {{-- Manage user --}}
            @if (optional(user())->hasRole('master'))
                <a href="/master/manage-users/{{ $user->visitor_id }}" class="btn-small mt-3 red">
                    @lang('manage-users.manage')
                </a>
            @endif
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
            <img src="{{ asset('storage/users/not_active.jpg') }}" class="profile-image corner z-depth-1 hoverable" alt="{{ $user->getName() }}" />
            <p>@lang('users.user_is_not_active')</p>
        </div>
    @endif
</div>

@endsection