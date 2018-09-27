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
                                <textarea name="message" id="textarea1" class="materialize-textarea counter" data-length="{{ config('validation.disapprove_message_max') }}" required></textarea>
                                <label for="textarea1">* @lang('notifications.set_message')</label>
                                <button class="btn red" type="submit" onclick="if (!confirm('@lang('recipes.are_you_sure_to_cancel')')) event.preventDefault()">@lang('form.send')</button>
                            </div>
                        </form>
                    </div>
                </div>
            @else
                <h6 class="green-text">
                    <i class="fas fa-search small"></i><br>
                    @lang('approves.currently_approving', ['user' => optional($recipe->approver)->name])
                </h6>
            @endif
        </div>

        @include('includes.parts.recipes-show')
    </div>
</section>

@endsection
