<footer class="px-5 pb-5">
    <div class="row pt-0 page">

        {{--  Top recipers  --}}
        <div class="col s12 m6 l3 left-align">
            <ul class="unstyled-list">
                <li>
                    <strong>@lang('pages.top_recipers')</strong>
                    <span class="main-light-text d-block"
                        style="font-size:14px;transform:translateY(-5.5px)"
                    >
                        @lang('pages.most_popular') <i class="fas fa-heart red-text"></i>
                    </span>
                    <span class="main-light-text d-block"
                        style="font-size:14px;transform:translateY(-10px)"
                    >
                        @lang('pages.in_a_day')
                    </span>
                </li>
                @forelse (cache()->get('top_recipers', []) as $key => $value)
                    <li>
                        <a href="/users/{{ $key }}"
                            class="{{ active_if_route_is(["users/$key"]) }}"
                        >
                            <i class="fas fa-crown" style="font-size:0.8em;color:orange"></i> 
                            {{ $key }} 
                            <span style="color:orange">
                                <i class="fas fa-heart" style="font-size:0.6em"></i> {{ $value }}
                            </span>
                        </a>
                    </li>
                @empty
                    <span class="grey-text">
                        <i class="fas fa-meh"></i> @lang('pages.no_recipers')
                    </span>
                @endforelse
            </ul>
        </div>
        
        {{--  Random recipes  --}}
        <div class="col s12 m6 l3 left-align">
            <ul class="unstyled-list">
                <li><strong>@lang('recipes.recipes')</strong></li>
                @foreach ($random_recipes as $recipe)
                    <li>
                        <a href="/recipes/{{ $recipe['slug'] }}"
                            class="{{ active_if_route_is(["recipes/{$recipe['slug']}"]) }}"
                        >
                            <i class="fas fa-angle-right red-text" style="width:7.5px"></i> 
                            {{ $recipe['title'] }}
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
                        <a href="/recipes/{{ $recipe['slug'] }}"
                            class="{{ active_if_route_is(["recipes/{$recipe['slug']}"]) }}">
                            <i class="fas fa-angle-right red-text" style="width:7.5px"></i> 
                            {{ $recipe['title'] }}
                        </a>
                    </li>
                @endforeach
            <ul>
        </div>

        {{-- Navigation --}}
        <div class="col s12 m6 l3 left-align row">
            <ul class="px-0 unstyled-list col s12">
                <li><strong>@lang('pages.navigation')</strong></li>
                {{-- Home page --}}
                <li>
                    <a href="/"
                        title="@lang('messages.go')"
                        class="{{ active_if_route_is(['/']) }}"
                    >
                        <i class="fas fa-angle-right red-text" style="width:7.5px"></i> 
                        @lang('home.home')
                    </a>
                </li>
                {{-- Add recipe --}}
                <li>
                    <a href="/recipes#new"
                        title="@lang('messages.go')"
                        class="{{ active_if_route_is(['recipes', 'recipes/*']) }}"
                    >
                        <i class="fas fa-angle-right red-text" style="width:7.5px"></i> 
                        @lang('recipes.recipes')
                    </a>
                </li>
                {{-- Search --}}
                <li>
                    <a href="/search"
                        title="@lang('messages.go')"
                        class="{{ active_if_route_is(['search']) }}"
                    >
                        <i class="fas fa-angle-right red-text" style="width:7.5px"></i>
                        @lang('pages.search')
                    </a>
                </li>
                {{-- Help --}}
                <li>
                    <a href="/help"
                        title="@lang('messages.go')"
                        class="{{ active_if_route_is(['help']) }}"
                    >
                        <i class="fas fa-angle-right red-text" style="width:7.5px"></i>
                        @lang('help.help')
                    </a>
                </li>
                {{-- Contact --}}
                <li>
                    <a href="/contact"
                        title="@lang('messages.go')"
                        class="{{ active_if_route_is(['contact']) }}"
                    >
                        <i class="fas fa-angle-right red-text" style="width:7.5px"></i>
                        @lang('feedback.contact_us')
                    </a>
                </li>
                {{-- Documents --}}
                <li>
                    <a href="/documents"
                        title="@lang('messages.go')"
                        class="{{ active_if_route_is(['documents']) }}"
                    >
                        <i class="fas fa-angle-right red-text" style="width:7.5px"></i>
                        @lang('documents.documents')
                    </a>
                </li>
                @guest
                    {{-- Login --}}
                    <li>
                        <a href="/login"
                            title="@lang('messages.go')"
                            class="{{ active_if_route_is(['login']) }}"
                        >
                            <i class="fas fa-angle-right red-text" style="width:7.5px"></i>
                            @lang('auth.login')
                        </a>
                    </li>
                    {{-- Register --}}
                    <li>
                        <a href="/register"
                            title="@lang('messages.go')"
                            class="{{ active_if_route_is(['register']) }}"
                        >
                            <i class="fas fa-angle-right red-text" style="width:7.5px"></i>
                            @lang('auth.register')
                        </a>
                    </li>
                @endguest
            </ul>
            {{-- Documents --}}
            <ul class="px-0 unstyled-list col s12">
                <li><a href="/documents"><strong>@lang('documents.info')</strong></a></li>
                @foreach ($documents_footer as $doc)
                    <li>
                        <a href="/documents/{{ $doc['id'] }}"
                            class="{{ active_if_route_is(["documents/{$doc['id']}"]) }}"
                        >
                            <i class="fas fa-angle-right red-text" style="width:7.5px"></i> 
                            {{ $doc['title'] }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <div class="center pt-2">
        <div>
            <a href="/contact"
                title="@lang('messages.go')"
                class="mr-3 {{ active_if_route_is(['contact']) }}"
            >
                <i class="fas fa-envelope mr-1" style="width:15px"></i>
                @lang('feedback.contact_us')
            </a>
            <a href="/help"
                title="@lang('messages.go')"
                class="{{ active_if_route_is(['help']) }}"
            >
                <i class="fas fa-question mr-1" style="width:11px"></i>
                @lang('help.help')
            </a>
        </div>

        <div class="footer-copyright mt-4 row">
            <div class="col s12 m1 l1 offset-m3 offset-l4 m">
                <img src="{{ asset('storage/other/logo.png') }}" alt="logo" height="50" />
            </div>
            <div class="col s12 m5 l3 left-align">
                <div class="valign-wrapper" style="height:70px">
                    <span>@lang('pages.title_footer') <br> &copy; {{ date('Y') }} {{ config('app.name') }}</span>
                </div>
            </div>
        </div>
    </div>
</footer>