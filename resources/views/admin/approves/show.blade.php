@extends('layouts.app')

@section('title', $recipe->getTitle())

@section('content')

<section class="grid-recipe pt-3">
    <div class="recipe-content center">

        <div class="py-2">
            @if ($recipe->getApproverId() == user()->id)
                <p>@lang('recipes.approve_or_not')</p>

                {{-- Approve --}}
                <form action="{{ action('Admin\ApprovesController@ok', ['recipe' => $recipe->id]) }}" method="post" class="d-inline-block" onsubmit="return confirm('@lang('recipes.are_you_sure_to_publish')')">
                    @csrf
                    <input type="hidden" name="message" value="ok">
                    <button class="btn green" type="submit">
                        @lang('messages.yes')
                        <i class="material-icons right">thumb_up</i>
                    </button>
                </form>

                {{-- Cancel --}}
                <a href="#modal3" class="btn red modal-trigger">
                    @lang('messages.no')
                    <i class="material-icons right">thumb_down</i>
                </a>

                <!-- Modal Structure -->
                <div id="modal3" class="modal">
                    <div class="modal-content reset">
                        <form action="{{ action('Admin\ApprovesController@cancel', ['recipe' => $recipe->id]) }}" method="post" onsubmit="return confirm('@lang('recipes.are_you_sure_to_cancel')')">
                            @csrf
                            <p>@lang('notifications.set_message_desc')</p>
                            <div class="input-field">
                                <textarea name="message" id="textarea1" class="materialize-textarea counter" data-length="{{ config('validation.approve_message') }}" minlength="30" required></textarea>
                                <label for="textarea1">* @lang('notifications.set_message')</label>
                                <button class="btn red" type="submit">@lang('form.send')</button>
                            </div>
                        </form>
                    </div>
                </div>
            @else
                <h6 class="green-text">
                    <i class="material-icons small">search</i><br />
                    @lang('approves.currently_approving', ['user' => $recipe->approver->name])
                </h6>
            @endif
        </div>

        @include('includes.recipe')
    </div>
</section>

@endsection
