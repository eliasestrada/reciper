@extends(auth()->check() ? 'layouts.auth' : 'layouts.guest')

@section('title', $recipe->getTitle())

@section('content')

<section class="grid-recipe pt-3">
    <div class="recipe-content center position-relative">
        <section class="not-printable">
            {{-- Edit button --}}
            @if (!$recipe->isReady())
                @component('comps.btns.fixed-btn')
                    @slot('icon') fa-pen @endslot
                    @slot('link') /recipes/{{ $recipe->slug }}/edit @endslot
                    @slot('tip') @lang('tips.edit') @endslot
                @endcomponent
            @endif

            {{-- Show menu button --}}
            <a href="#" title="@lang('recipes.show_menu')">
                <i class="fas fa-ellipsis-v fa-15x px-3 py-2 main-text right" id="popup-window-trigger" style="transform:translateX(-15px)"></i>
            </a>

            <div class="popup-window z-depth-2 p-3 position-absolute paper" id="popup-window">
                {{-- Report button --}}
                <a href="#report-recipe-modal"
                    title="@lang('recipes.report_recipe')"
                    class="btn waves-effect waves-light modal-trigger min-w"
                    {{ visitor_id() == $recipe->user_id
                        || optional(user())->hasRecipe($recipe->id)
                        ? ' disabled'
                        : ''
                    }}
                >
                    @lang('recipes.report_recipe')
                </a>

                {{--  To drafts button  --}}
                @if (optional(user())->hasRecipe($recipe->id) && $recipe->isDone())
                    <form action="{{ action('RecipesController@update', ['recipe' => $recipe->id]) }}"
                        method="post"
                    >
                        @method('put') @csrf

                        <button class="btn min-w confirm"
                            data-confirm="@lang('recipes.are_you_sure_to_draft')"
                            title="@lang('tips.add_to_drafts')"
                        >
                            @lang('tips.add_to_drafts')
                        </button>
                    </form>
                @endif

                {{-- Edit button --}}
                @if (optional(user())->hasRecipe($recipe->id))
                    <a href="/recipes/{{ $recipe->slug }}/edit"
                        class="btn mt-2 min-w" {{ $recipe->isReady() ? 'disabled' : '' }}
                        title="@lang('tips.edit')"
                    >
                        @lang('tips.edit')
                    </a>
                @endif

                {{-- Print --}}
                <a href="#" class="btn min-w" onclick="window.print()" title="@lang('messages.print')">
                    @lang('messages.print')
                </a>
            </div>

            {{--  Likes  --}}
            <div class="like-for-author-section no-select pt-1" v-if="false">
                <div class="card-content">@include('includes.preloader')</div>
            </div>
            <div class="like-for-author-section no-select py-1" v-cloak>
                @if ($recipe->isDone())
                    {{-- Favs button --}}
                    <div class="d-inline-block" style="transform:translateX(7px)">
                        <btn-favs recipe-id="{{ $recipe->id }}"
                            :items="{{ $recipe->favs }}"
                            audio-path="{{ asset('storage/audio/fav-effect.wav') }}"
                            :user-id="{{ auth()->check() ? user()->id : 'null' }}"
                            tooltip="@lang('messages.u_need_to_login')"
                        >
                    </div>

                    {{-- User icon --}}
                    <a href="/users/{{ $recipe->user->username }}"
                        class="user-icon-on-single-recipe z-depth-2 hoverable {{ $xp->getColor() }}"
                        style="background:#484074 url({{ asset('storage/small/users/' . $recipe->user->photo) }})"
                        title="@lang('users.go_to_profile') {{ $recipe->user->getName() }}"
                    ></a>

                    {{-- Level badge --}}
                    <div class="level-badge-wrap z-depth-2 d-inline-block ml-0 z-depth-2 hoverable {{ $xp->getColor() }}">
                        <div class="level-badge tooltipped {{ $xp->getColor() }}"
                            data-tooltip="@lang('users.user_level_is', ['level' => $xp->getLevel()])"
                            data-position="top"
                        >
                            <span>{{ $xp->getLevel() }}</span>
                        </div>
                    </div>

                    <btn-like :items="{{ $recipe->likes }}"
                        recipe-id="{{ $recipe->id }}"
                        audio-path="{{ asset('storage/audio/like-effect.mp3') }}"
                        :user-id="{{ auth()->check() ? user()->id : 'null' }}"
                        tooltip="@lang('messages.u_need_to_login')"
                    >
                @endif
            </div>
        </section>

        @include('includes.parts.recipes-show')
    </div>

    {{-- API: Еще рецепты Sidebar --}}
    <div class="side-bar center not-printable">
        <h6 class="decorated pb-3">@lang('recipes.more')</h6>
        <random-recipes-sidebar visitor-id="{{ visitor_id() }}" inline-template>
            <div>
                <div class="card hoverable"
                    v-for="recipe in recipes"
                    :key="recipe.id"
                >
                    <div>
                        <a :href="'/recipes/' + recipe.slug" :title="recipe.title">
                            <div class="placeholder-image"
                                style="height:105px; {{ setRandomBgColor() }}"
                            ></div>
                            <img class="activator lazy-load-img"
                                :src="`/storage/small/recipes/${recipe.image}`"
                                style="width:100%; border-radius:7px 7px 0 0"
                                :alt="recipe.title"
                            >
                        </a>
                    </div>
                    <div class="card-content p-3" v-text="recipe.title">
                        @include('includes.preloader')
                    </div>
                </div>
            </div>
        </random-recipes-sidebar>
    </div>
</section>


<!-- report-recipe-modal structure -->
@if (visitor_id() != $recipe->user_id)
    <div id="report-recipe-modal" class="modal not-printable">
        <div class="modal-content reset">
            <form action="{{ action('Admin\FeedbackController@store') }}" method="post">
                @csrf

                <h5>@lang('recipes.report_recipe')</h5>
                <p>@lang('feedback.report_message_desc')</p>

                <div class="input-field mt-4">
                    <input type="hidden" name="recipe_id" value="{{ $recipe->id }}">

                    <textarea name="message" id="message"
                        minlength="{{ config('valid.feedback.contact.message.min') }}"
                        class="materialize-textarea counter"
                        data-length="{{ config('valid.feedback.contact.message.max') }}"
                        required
                    >{{ old('message') }}
                    </textarea>

                    <label for="message">@lang('forms.message')</label>
                </div>
                <button type="submit" class="btn">@lang('forms.send')</button>
            </form>
        </div>
    </div>
@endif

@endsection
