<ul class="sidenav" id="mobile-demo">
    <li>
        <div class="user-view">
            <div class="background">
                <img src="{{ asset('storage/other/img-small.jpg') }}">
            </div>

            @guest
                <a href="/login" class="btn waves-effect waves-light min-w" title="@lang('auth.login')">
                    @lang('auth.login')
                </a>
                <br>
                <a href="/register" class="btn waves-effect waves-light min-w mb-2" title="@lang('auth.register')">
                    @lang('auth.register')
                </a>
            @else
                <a href="/users/{{ user()->username }}">
                    <img class="circle z-depth-1 hoverable" src="{{ asset('storage/users/' . user()->photo) }}">
                </a>
                <a href="/users/{{ user()->username }}">
                    <span class="white-text name">{{ user()->getName() }}</span>
                </a>
                <a href="#email">
                    <span class="white-text email">
                        @lang('users.popularity') 
                        <i class="fas fa-crown" style="font-size:0.8em;color:orange"></i> 
                        {{ user()->popularity }}
                    </span>
                </a>
            @endguest
        </div>
    </li>

    <li class="{{ active_if_route_is(['/']) }}">
        <a href="/">
            <i class="fas fa-home fa-15x grey-text left"></i>
            @lang('home.home')
        </a>
    </li>
    <li class="{{ active_if_route_is(['recipes*']) }}">
        <a href="/recipes#new">
            <i class="fas fa-book-open fa-15x grey-text left"></i>
            @lang('recipes.recipes')
        </a>
    </li>
    <li class="{{ active_if_route_is(['search']) }}">
        <a href="/search">
            <i class="fas fa-search fa-15x grey-text left"></i>
            @lang('pages.search')
        </a>
    </li>
    <li class="{{ active_if_route_is(['help']) }}">
        <a href="/help" title="@lang('messages.help')">
            <i class="fas fa-question-circle fa-15x grey-text left"></i>
            @lang('messages.help')
        </a>
        <div class="divider"></div>
    </li>

    <li>
        <a class="subheader grey-text">@lang('pages.categories')</a>
    </li>

    @include('includes.nav.categories')
</ul>