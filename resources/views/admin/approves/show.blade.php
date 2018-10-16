@extends('layouts.app')

@section('title', $recipe->getTitle())

@section('content')

<section class="grid-recipe pt-3">
    <div class="recipe-content center">

        <div class="py-2">
            @if ($approver_id == user()->id)
                <p>@lang('recipes.approve_or_not')</p>

                {{-- Approve --}}
                <form action="{{ action('Admin\ApprovesController@approve', ['id' => $recipe->id]) }}" method="post" class="d-inline-block" onsubmit="return confirm('@lang('recipes.are_you_sure_to_publish')')">
                    @csrf
                    <button class="btn green" type="submit">
                        @lang('messages.yes') <i class="fas fa-thumbs-up right"></i>
                    </button>
                </form>

                {{-- Disapprove --}}
                <a href="#disapprove-modal" class="btn red modal-trigger">
                    @lang('messages.no') <i class="fas fa-thumbs-down right"></i>
                </a>

                <!--  disapprove-publishing-modal structure -->
                <div id="disapprove-modal" class="modal">
                    <div class="modal-content reset">
                        <form action="{{ action('Admin\ApprovesController@disapprove', ['recipe' => $recipe->id]) }}" method="post">
                            @csrf
                            <p>@lang('notifications.set_message_desc')</p>
                            <div class="input-field">
                                <textarea name="message" id="textarea1" class="materialize-textarea counter" data-length="{{ config('valid.approves.disapprove.message.max') }}" required></textarea>
                                <label for="textarea1">* @lang('notifications.set_message')</label>
                                <button class="btn red" type="submit" onclick="if (!confirm('@lang('recipes.are_you_sure_to_cancel')')) event.preventDefault()">@lang('forms.send')</button>
                            </div>
                        </form>
                    </div>
                </div>
            @else
                <div class="no-select">
                    {{-- Approver icon --}}
                    <a href="/users/{{ $recipe->approver->username }}" title="@lang('users.go_to_profile')">
                        <img src="{{ asset('storage/small/users/' . $recipe->approver->image) }}" class="circle" style="border:3px solid green" alt="{{ $recipe->approver->getName() }}" width="50">
                        <i class="fas fa-search fa-15x paper circle p-1" style="color:green;transform:translateX(-20px)"></i>
                    </a>
                    <i class="fas fa-arrow-right fa-3x green-text mr-4"></i>
                    {{-- Author icon --}}
                    <a href="/users/{{ $recipe->user->username }}" title="@lang('users.go_to_profile')">
                        <img src="{{ asset('storage/small/users/' . $recipe->user->image) }}" class="circle" style="border:3px solid green" alt="{{ $recipe->approver->getName() }}" width="50">
                        <i class="fas fa-file-alt fa-15x paper p-1" style="color:green;transform:translateX(-20px)"></i><br>
                    </a>
                    <p class="main-text my-1">
                        {!! trans('approves.currently_approving', [
                            'admin' => $recipe->approver->getName(),
                            'user' => $recipe->user->getName(),
                        ]) !!}
                    </p>
                </div>
            @endif
        </div>

        @include('includes.parts.recipes-show')
    </div>
</section>

@endsection
