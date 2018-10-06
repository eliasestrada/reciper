<footer class="px-5 pt-3 pb-5">
    <div class="row wrapper">
        <div class="col s12 m6 l3 left-align row">
            {{-- Navigation --}}
            <ul class="px-0 unstyled-list col s12">
                <li><strong>@lang('pages.navigation')</strong></li>
                <li>
                    <a href="/" title="@lang('messages.go')">
                        <i class="fas fa-angle-right red-text"></i> @lang('home.home')
                    </a>
                </li>
                <li>
                    <a href="/recipes" title="@lang('messages.go')">
                        <i class="fas fa-angle-right red-text"></i> @lang('recipes.recipes')
                    </a>
                </li>
                <li>
                    <a href="/search" title="@lang('messages.go')">
                        <i class="fas fa-angle-right red-text"></i> @lang('pages.search')
                    </a>
                </li>
                <li>
                    <a href="/help" title="@lang('messages.go')">
                        <i class="fas fa-angle-right red-text"></i> @lang('messages.help')
                    </a>
                </li>
                <li>
                    <a href="/contact" title="@lang('messages.go')">
                        <i class="fas fa-angle-right red-text"></i> @lang('feedback.contact_us')
                    </a>
                </li>
                <li>
                    <a href="/login" title="@lang('messages.go')">
                        <i class="fas fa-angle-right red-text"></i> @lang('auth.login')
                    </a>
                </li>
                <li>
                    <a href="/register" title="@lang('messages.go')">
                        <i class="fas fa-angle-right red-text"></i> @lang('auth.register')
                    </a>
                </li>
            </ul>
            {{-- Documents --}}
            <ul class="px-0 unstyled-list col s12">
                <li><strong>@lang('documents.info')</strong></li>
                @foreach ($documents_footer as $doc)
                    <li>
                        <a href="/documents/{{ $doc->id }}">
                            <i class="fas fa-angle-right red-text"></i> {{ $doc->getTitle() }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        {{--  Random recipes  --}}
        <div class="col s12 m6 l3 left-align">
            <ul class="unstyled-list">
                <li><strong>@lang('recipes.recipes')</strong></li>
                @foreach ($random_recipes as $recipe)
                    <li>
                        <a href="/recipes/{{ $recipe->id }}">
                            <i class="fas fa-angle-right red-text"></i> {{ $recipe->getTitle() }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        {{--  Popular recipes  --}}
        <div class="col s12 m6 l3 left-align">
            <ul class="unstyled-list">
                <li><strong>@lang('recipes.popular')</strong></li>
                @foreach ($popular_recipes as $recipe)
                    <li>
                        <a href="/recipes/{{ $recipe->id }}">
                            <i class="fas fa-angle-right red-text"></i> {{ $recipe->getTitle() }}
                        </a>
                    </li>
                @endforeach
            <ul>
        </div>

        {{--  Top recipers  --}}
        <div class="col s12 m6 l3 left-align">
            <ul class="unstyled-list">
                <li><strong>@lang('pages.top_recipers')</strong></li>
                @foreach ($top_recipers as $i => $reciper)
                    <li>
                        <a href="/users/{{ $reciper->id }}">
                            <i class="fas fa-crown" style="font-size:0.8em;color:orange"></i> 
                            {{ $reciper->name }} ({{ $reciper->exp }})
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <div class="center pt-2">
        <div>
            <a href="/contact" title="@lang('messages.go')" class="mr-3">
                <i class="fas fa-envelope mr-1"></i>
                @lang('feedback.contact_us')
            </a>
            <a href="/help" title="@lang('messages.go')">
                <i class="fas fa-question mr-1"></i>
                @lang('messages.help')
            </a>
        </div>

        <div class="footer-copyright mt-4 row">
            <div class="col s12 m1 l1 offset-m3 offset-l4 m">
                <img src="{{ asset('storage/other/logo.svg') }}" alt="logo" height="40">
            </div>
            <div class="col s12 m5 l3 left-align">
                <span>{{ $title_footer ?? '' }}</span><br>
                <span>&copy; {{ date('Y') }} {{ config('app.name') }}</span>
            </div>
        </div>
    </div>

    @hasRole('admin')
        {{--  Настройки подвала  --}}
        <div class="position-relative">
            <a class="magic-btn" title="@lang('home.edit_banner')" id="btn-for-footer">
                <i class="fa fa-pen"></i>
            </a>
            @magicForm
                @slot('id')
                    footer-form
                @endslot
                @slot('text')
                    {{ $title_footer }}
                @endslot
                @slot('action')
                    TitleController@footer
                @endslot
                @slot('holder_text')
                    @lang('home.footer_text')
                @endslot
                @slot('slug_text')
                    footer_text
                @endslot
            @endmagicForm
        </div>
    @endhasRole
</footer>