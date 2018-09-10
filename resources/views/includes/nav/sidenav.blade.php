<ul class="sidenav" id="mobile-demo">
    @guest
        <div class="sidebar-hat-guest center">
            <a href="/login" class="btn waves-effect waves-light min-w" title="@lang('includes.enter')">
                @lang('includes.enter')
                <i class="material-icons right">exit_to_app</i>
            </a><br />
            <a href="/register" class="btn waves-effect waves-light min-w" title="@lang('includes.register')">
                @lang('includes.register')
                <i class="material-icons right">exit_to_app</i>
            </a>
        </div>
    @else
        <div class="sidebar-hat-auth center"
            style="background-image:url({{ asset('storage/users/'.user()->image) }})">
        </div>
    @endguest

    <li class="{{ active_if_route_is('/') }}">
        <a href="/" title="@lang('includes.home')">
            @lang('includes.home')
        </a>
    </li>
    <li class="{{ active_if_route_is('recipes') }}">
        <a href="/recipes" title="@lang('includes.recipes')">
            @lang('includes.recipes')
        </a>
    </li>



    <div class="divider"></div>

    @include('includes.nav.categories')
</ul>