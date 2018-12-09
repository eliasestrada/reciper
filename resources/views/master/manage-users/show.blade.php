@extends('layouts.auth')

@section('title', trans('users.user') . ' ' . $user->getName())

@section('content')

@include('includes.buttons.back', ['url' => '/master/manage-users'])

<div class="page row">
    <div class="center col s12 m6">
        <div><h1 class="header mb-4">{{ $user->getName() }}</span></h1></div>

        <img src="{{ asset('storage/small/users/'.$user->photo) }}" data-lazy-load="{{ asset('storage/big/users/'.$user->photo) }}" class="profile-image frames z-depth-1 hoverable lazy-load-img" alt="{{ $user->getName() }}" />

        {{-- Go to profile --}}
        <div class="my-2">
            <a href="/users/{{ $user->username }}" class="btn-small min-w">
                <i class="fas fa-user-circle left"></i>
                @lang('users.go_to_profile')
            </a>
        </div>

        @if ($user->id != 1)
            @if ($user->isBanned())
                <div class="pt-2"> {{-- Unban button --}}
                    <form class="row" action="{{ action('Master\ManageUsersController@destroy', ['id' => $user->id]) }}" method="post" onsubmit="return confirm('@lang('manage-users.are_you_sure_to_unban')')">
                        @csrf @method('delete')
                        <button class="btn red" type="submit">
                            <i class="fas fa-lock-open left"></i> @lang('manage-users.unban')
                        </button>
                    </form>
                </div>
            @else
                <div> {{-- Ban button trigger --}}
                    <a href="#ban-user-modal" class="btn-small min-w red modal-trigger">
                        <i class="fas fa-lock left"></i> @lang('manage-users.ban')
                    </a>
                </div>
            @endif
        @endif
    </div>

    <div class="col s12 m6">
        <table class="mt-3 responsive">
            <tbody>
                <tr> {{-- Last activity --}}
                    <td>
                        @lang('visitors.last_activity'): <span class="red-text">{{ $user->updated_at }}</span> ({{ time_ago($user->online_check) }})
                    </td>
                </tr>
                <tr> {{-- Firt visit --}}
                    <td>
                        @lang('visitors.first_visit'): <span class="red-text">{{ $user->created_at }}</span> ({{ time_ago($user->created_at) }})
                    </td>
                </tr>
                <tr> {{-- Days with us --}}
                    <td>@lang('visitors.days_with_us'): <span class="red-text">{{ $user->daysWithUs() }}</span></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!--  ban-user-modal structure -->
@if ($user->id != 1 || !$user->isBanned())
    <div id="ban-user-modal" class="modal">
        <div class="modal-content reset">
            <form class="row" action="{{ action('Master\ManageUsersController@update', ['id' => $user->id]) }}" method="post">

                @csrf @method('put')

                <p>@lang('manage-users.what_reason_to_ban')</p>
                <div class="input-field col s12 m3">
                    <input type="number" id="ban-input" name="days" value="{{ old('days') }}">
                    <label for="ban-input">@lang('manage-users.days')</label>
                    @include('includes.input-error', ['field' => 'days'])
                </div>
                <div class="input-field col s12 m9">
                    <textarea name="message" id="ban-textarea" class="materialize-textarea counter" data-length="{{ config('valid.feedback.ban.message.max') }}" maxlength="{{ config('valid.feedback.ban.message.max') }}" required>{{ old('message') }}</textarea>
                    <label for="ban-textarea">@lang('forms.message')</label>
                    @include('includes.input-error', ['field' => 'message'])
                </div>
                <button class="btn red confirm" type="submit" data-confirm="@lang('manage-users.are_you_sure_to_ban')">
                    @lang('manage-users.ban')
                </button>
            </form>
        </div>
    </div>
@endif

@endsection