<footer class="px-5 pt-3 pb-5">
    <div class="row wrapper">
        {{--  Navigation  --}}
        <div class="col s12 m6 l3 left-align">
            <ul class="unstyled-list">
                <li><strong>@lang('includes.navigation')</strong></li>
                <li>
                    <a href="/" class="{{ active_if_route_is('/') }}">
                        @lang('includes.home')
                    </a>
                </li>
                <li>
                    <a href="/recipes" class="{{ active_if_route_is('recipes') }}">
                        @lang('includes.recipes')
                    </a>
                </li>
                <li>
                    <a href="/contact" class="{{ active_if_route_is('contact') }}">
                        @lang('includes.feedback')
                    </a>
                </li>
                <li>
                    <a href="/search" class="{{ active_if_route_is('search') }}">
                        @lang('includes.search')
                    </a>
                </li>
            </ul>
        </div>

        {{--  Random recipes  --}}
        <div class="col s12 m6 l3 left-align">
            <ul class="unstyled-list">
                <li><strong>@lang('includes.recipes')</strong></li>
                @foreach ($random_recipes as $recipe)
                    <li>
                        <a href="/recipes/{{ $recipe->id }}" title="{{ $recipe->getTitle() }}">
                            <span class="red-text">#</span> {{ $recipe->getTitle() }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        {{--  Popular recipes  --}}
        <div class="col s12 m6 l3 left-align">
            <ul class="unstyled-list">
                <li><strong>@lang('includes.popular_recipes')</strong></li>
                @foreach ($popular_recipes as $recipe)
                    <li>
                        <a href="/recipes/{{ $recipe->id }}" title="{{ $recipe->getTitle() }}">
                            <span class="red-text" >#</span> {{ $recipe->getTitle() }}
                        </a>
                    </li>
                @endforeach
            <ul>
        </div>

        {{--  Top recipers  --}}
        <div class="col s12 m6 l3 left-align">
            <ul class="unstyled-list">
                <li><strong>@lang('includes.top_recipers')</strong></li>
                @foreach ($top_recipers as $i => $reciper)
                    <li>
                        <a href="/users/{{ $reciper->id }}" title="{{ $reciper->name }}">
                            <i class="material-icons tiny" style="font-size:0.8em;color:orange">star</i> 
                            {{ $reciper->name }} ({{ $reciper->points }})
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <div class="center">
        <a href="/" title="@lang('includes.home')">
            <img src="{{ asset('favicon.png') }}" alt="@lang('includes.logo')" class="footer-logo">
        </a>
    
        <p class="footer-copyright">
            &copy; {{ date('Y') }} {{ config('app.name') }} <br /> {{ $title_footer ?? '' }}
        </p>
    </div>

    @hasRole('admin')
        {{--  Настройки подвала  --}}
        <div class="position-relative">
            <a class="magic-btn" title="@lang('home.edit_banner')" id="btn-for-footer">
                <i class="material-icons">edit</i>
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