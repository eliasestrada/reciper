<footer class="px-5 pb-5">
    <div class="row pt-0 page">

        {{--  Top recipers  --}}
        <div class="col s12 m6 l3 left-align">
            <ul class="unstyled-list">
                <li>
                    <strong>@lang('pages.top_recipers')</strong>
                    <span class="main-light-text d-block" style="font-size:14px;transform:translateY(-5.5px)">
                        @lang('pages.most_popular') <i class="fas fa-heart red-text"></i>
                    </span>
                    <span class="main-light-text d-block" style="font-size:14px;transform:translateY(-10px)">
                        @lang('pages.in_a_day')
                    </span>
                </li>
                @forelse ($top_recipers as $reciper)
                    <li>
                        <a href="/users/{{ $reciper['id'] }}">
                            <i class="fas fa-crown" style="font-size:0.8em;color:orange"></i> {{ $reciper['name'] }}
                        </a>
                    </li>
                @empty
                    <span class="grey-text"><i class="fas fa-meh"></i> @lang('pages.no_recipers')</span>
                @endforelse
            </ul>
        </div>
        
        {{--  Random recipes  --}}
        <div class="col s12 m6 l3 left-align">
            <ul class="unstyled-list">
                <li><strong>@lang('recipes.recipes')</strong></li>
                @foreach ($random_recipes as $recipe)
                    <li>
                        <a href="/recipes/{{ $recipe->id }}">
                            <i class="fas fa-angle-right red-text" style="width:7.5px"></i> {{ $recipe->getTitle() }}
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
                            <i class="fas fa-angle-right red-text" style="width:7.5px"></i> {{ $recipe->getTitle() }}
                        </a>
                    </li>
                @endforeach
            <ul>
        </div>

        <div class="col s12 m6 l3 left-align row">
            {{-- Navigation --}}
            <ul class="px-0 unstyled-list col s12">
                <li><strong>@lang('pages.navigation')</strong></li>
                <li>
                    <a href="/" title="@lang('messages.go')">
                        <i class="fas fa-angle-right red-text" style="width:7.5px"></i> @lang('home.home')
                    </a>
                </li>
                <li>
                    <a href="/recipes" title="@lang('messages.go')">
                        <i class="fas fa-angle-right red-text" style="width:7.5px"></i> @lang('recipes.recipes')
                    </a>
                </li>
                <li>
                    <a href="/search" title="@lang('messages.go')">
                        <i class="fas fa-angle-right red-text" style="width:7.5px"></i> @lang('pages.search')
                    </a>
                </li>
                <li>
                    <a href="/help" title="@lang('messages.go')">
                        <i class="fas fa-angle-right red-text" style="width:7.5px"></i> @lang('messages.help')
                    </a>
                </li>
                <li>
                    <a href="/contact" title="@lang('messages.go')">
                        <i class="fas fa-angle-right red-text" style="width:7.5px"></i> @lang('feedback.contact_us')
                    </a>
                </li>
                <li>
                    <a href="/login" title="@lang('messages.go')">
                        <i class="fas fa-angle-right red-text" style="width:7.5px"></i> @lang('auth.login')
                    </a>
                </li>
                <li>
                    <a href="/register" title="@lang('messages.go')">
                        <i class="fas fa-angle-right red-text" style="width:7.5px"></i> @lang('auth.register')
                    </a>
                </li>
            </ul>
            {{-- Documents --}}
            <ul class="px-0 unstyled-list col s12">
                <li><strong>@lang('documents.info')</strong></li>
                @foreach ($documents_footer as $doc)
                    <li>
                        <a href="/documents/{{ $doc->id }}">
                            <i class="fas fa-angle-right red-text" style="width:7.5px"></i> {{ $doc->getTitle() }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <div class="center pt-2">
        <div>
            <a href="/contact" title="@lang('messages.go')" class="mr-3">
                <i class="fas fa-envelope mr-1" style="width:15px"></i>
                @lang('feedback.contact_us')
            </a>
            <a href="/help" title="@lang('messages.go')">
                <i class="fas fa-question mr-1" style="width:11px"></i>
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