@extends('layouts.app')

@section('title', trans('users.user') . ' ' . $user->name)

@section('content')

<div class="page">
    <div class="center">
        <div><h1 class="headline mb-4">{{ $user->name }}</span></h1></div>

        <img src="{{ asset('storage/users/'.$user->image) }}" class="profile-image corner z-depth-1 hoverable" alt="{{ $user->name }}" />
        <div class="my-2">
            <a href="/users/{{ $user->id }}" class="btn-small min-w">
                @lang('users.go_to_profile')
            </a>
        </div>

        <div class="mt-2">
            <a href="/master/manage-users" class="btn-small min-w">
                @lang('messages.back') 
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
                    <a href="#ban-user-modal" class="btn-small mt-2 min-w red modal-trigger">
                        <i class="fas fa-lock left"></i> @lang('manage-users.ban')
                    </a>
                </div>
            @endif
        @endif
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
                    </div>
                    <div class="input-field col s12 m9">
                        <textarea name="message" id="ban-textarea" class="materialize-textarea counter" data-length="{{ config('valid.feedback.ban.message.max') }}" maxlength="{{ config('valid.feedback.ban.message.max') }}" minlength="{{ config('valid.feedback.ban.message.min') }}" required>{{ old('message') }}</textarea>
                        <label for="ban-textarea">@lang('forms.message')</label>
                    </div>
                    <button class="btn red" type="submit" onclick="if (!confirm('@lang('manage-users.are_you_sure_to_ban')')) event.preventDefault()">@lang('manage-users.ban')</button>
                </form>
            </div>
        </div>
    @endif

    <table class="mt-3 responsive">
        <tbody>
            <tr> {{-- Last activity --}}
                <td>
                    @lang('visitors.last_activity'): <span class="red-text">{{ $user->updated_at }}</span> ({{ time_ago($user->updated_at) }})
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

@endsection