@extends('layouts.app')

@section('title', trans('visitors.visitor') . ' ' . $visitor->id)

@section('content')

@include('includes.buttons.back', ['url' => '/master/visitors'])

<div class="page row">
    <div class="center col s12 m6">
        <div>
            <h1 class="headline mb-4">
                <i class="fas fa-circle tiny {{ $visitor->getStatusColor() }}-text"></i>
                @lang('visitors.visitor'): <span class="red-text">{{ $visitor->id }}</span>
            </h1>
        </div>

        @if ($visitor->user)
            <img src="{{ asset('storage/users/'.$visitor->user->image) }}" class="profile-image corner z-depth-1 hoverable" alt="{{ $visitor->user->name }}" />
            <div class="my-2">

                <a href="/users/{{ $visitor->user->id }}" class="btn-small min-w">
                    <i class="fas fa-user-circle left"></i>
                    @lang('users.go_to_profile')
                </a>
            </div>
        @endif

        <div class="my-2">
            <a href="/master/manage-users/{{ $visitor->user->id }}" class="btn-small min-w">
                <i class="fas fa-user-cog left"></i>
                @lang('manage-users.manage') 
            </a>
        </div>
    </div>

    <div class="col s12 m6">
        <table class="mt-3 responsive">
            <tbody>
                <tr> {{-- Recipes liked --}}
                    <td>@lang('visitors.gave_likes'): <span class="red-text">{{ $visitor->likes->count() }}</span></td>
                </tr>
                <tr> {{-- Recipes viewed --}}
                    <td>@lang('visitors.recipes_viewed'): <span class="red-text">{{ $visitor->views->count() }}</span></td>
                </tr>
                <tr> {{-- All views --}}
                    <td>@lang('visitors.all_views'): <span class="red-text">{{ $visitor->views->sum('visits') }}</span></td>
                </tr>
                <tr> {{-- Last activity --}}
                    <td>
                        @lang('visitors.last_activity'): <span class="red-text">{{ $visitor->updated_at }}</span> ({{ time_ago($visitor->updated_at) }})
                    </td>
                </tr>
                <tr> {{-- Firt visit --}}
                    <td>
                        @lang('visitors.first_visit'): <span class="red-text">{{ $visitor->created_at }}</span> ({{ time_ago($visitor->created_at) }})
                    </td>
                </tr>
                <tr> {{-- Days with us --}}
                    <td>@lang('visitors.days_with_us'): <span class="red-text">{{ $visitor->daysWithUs() }}</span></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection