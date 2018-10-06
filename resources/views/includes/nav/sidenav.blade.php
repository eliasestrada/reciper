<ul class="sidenav" id="mobile-demo">
    @guest
        <div class="sidebar-hat-guest center">
            <a href="/login" class="btn waves-effect waves-light min-w" title="@lang('auth.login')">
                @lang('auth.login')
            </a><br>
            <a href="/register" class="btn waves-effect waves-light min-w" title="@lang('auth.register')">
                @lang('auth.register')
            </a>
        </div>
    @else
        <div class="sidebar-hat-auth center"
            style="background-image:url({{ asset('storage/users/'.user()->image) }})">
        </div>
    @endguest

    <li class="{{ active_if_route_is('/') }}">
        <a href="/">
            @lang('home.home')
        </a>
    </li>
    <li class="{{ active_if_route_is('recipes') }}">
        <a href="/recipes">
            @lang('recipes.recipes')
        </a>
    </li>
    <li class="{{ active_if_route_is('search') }}">
        <a href="/search">
            @lang('pages.search')
        </a>
    </li>
    <li class="{{ active_if_route_is('help') }}">
        <a href="/help" title="@lang('messages.help')">
            @lang('messages.help')
        </a>
    </li>



    <div class="divider"></div>

    @include('includes.nav.categories')
</ul>