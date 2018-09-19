@extends('layouts.app')

@section('title', trans('visitors.visitor') . ' ' . $visitor->id)

@section('content')

<div class="page">
    <div class="center">
        <div>
            <h1 class="headline mb-4">
                <i class="material-icons tiny {{ $visitor->getStatusColor() }}-text">lens</i>
                @lang('visitors.visitor'): <span class="red-text">{{ $visitor->id }}</span>
            </h1>
        </div>

        @if ($visitor->user)
            <div class="image-wrapper">
                <img src="{{ asset('storage/users/'.$visitor->user->image) }}" alt="{{ $visitor->user->name }}" />
            </div>
            <div class="my-2">
                <a href="/users/{{ $visitor->user->id }}">
                    @lang('messages.go_to_profile') 
                </a>
            </div>
        @endif

        <div class="my-2">
            <a href="/master/visitors">
                @lang('messages.back') 
            </a>
        </div>

        @if ($visitor->id != 1)
            @if ($visitor->isBanned())
                <div> {{-- Unban button --}}
                    <form class="row" action="{{ action('Master\VisitorsController@destroy', ['id' => $visitor->id]) }}" method="post" onsubmit="return confirm('@lang('visitors.are_you_sure_to_unban')')">
                        @csrf @method('delete')
                        <button class="btn red" type="submit">
                            <i class="material-icons left">lock_open</i> @lang('visitors.unban')
                        </button>
                    </form>
                </div>
            @else
                <div> {{-- Ban button trigger --}}
                    <a href="#ban-visitor-modal" class="btn-small mt-3 red modal-trigger">
                        <i class="material-icons left">lock_outline</i> @lang('visitors.ban')
                    </a>
                </div>
            @endif
        @endif
    </div>

    <!--  ban-visitor-modal structure -->
    @if ($visitor->id != 1 || !$visitor->isBanned())
        <div id="ban-visitor-modal" class="modal">
            <div class="modal-content reset">
                <form class="row" action="{{ action('Master\VisitorsController@update', ['visitor' => $visitor->id]) }}" method="post" onsubmit="return confirm('@lang('visitors.are_you_sure_to_ban')')">

                    @csrf @method('put')

                    <p>@lang('visitors.what_reason_to_ban')</p>
                    <div class="input-field col s12 m3">
                        <input type="number" id="ban-input" name="days" value="{{ old('days') }}">
                        <label for="ban-input">@lang('visitors.days')</label>
                    </div>
                    <div class="input-field col s12 m9">
                        <textarea name="message" id="ban-textarea" class="materialize-textarea counter" data-length="{{ config('validation.ban_message') }}" minlength="30" required>{{ old('message') }}</textarea>
                        <label for="ban-textarea">@lang('form.message')</label>
                    </div>
                    <button class="btn red" type="submit">@lang('visitors.ban')</button>
                </form>
            </div>
        </div>
    @endif

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

@endsection