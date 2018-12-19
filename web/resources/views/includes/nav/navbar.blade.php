{{-- User Dropdown menu --}}
<ul id="user-menu-dropdown" class="dropdown-content bottom-borders">
    @auth
        {{-- home --}}
        <li class="{{ active_if_route_is(['users/' . user()->username]) }}">
            <a href="/users/{{ user()->username }}" title="@lang('users.my_account')">
                <i class="fas fa-user-circle fa-15x left with-red-hover"></i>
                @lang('users.my_account')
            </a>
        </li>

        {{-- add recipe --}}
       <li class="{{ active_if_route_is(['recipes/edit']) }}">
            <a href="#add-recipe-modal" title="@lang('recipes.new_recipe')" class="modal-trigger">
                <i class="fas fa-plus-circle fa-15x left with-red-hover"></i>@lang('recipes.new_recipe')
            </a>
        </li>

        {{-- my recipes --}}
        <li class="{{ active_if_route_is(['users/other/my-recipes']) }}">
            <a href="/users/other/my-recipes" title="@lang('recipes.my_recipes')">
                <i class="fas fa-book-open fa-15x left with-red-hover"></i>
                @lang('recipes.my_recipes')
            </a>
        </li>

        {{-- users --}}
        <li class="{{ active_if_route_is(['users']) }}">
            <a href="/users" title="@lang('users.users')">
                <i class="fas fa-user-friends fa-15x left with-red-hover"></i>
                @lang('users.users')
            </a>
        </li>

        {{-- favorites --}}
        <li class="{{ active_if_route_is(['favs']) }}">
            <a href="/favs" title="@lang('messages.favorites')">
                <i class="fas fa-star fa-15x left with-red-hover"></i>
                @lang('messages.favorites')
            </a>
        </li>

        @hasRole('admin')
            <ul class="collapsible" id="adminka-collapsible">
                <li title="@lang('messages.adminka')" class="position-relative {{ 
                        $logs_notif || $unapproved_notif || $feedback_notif || $trash_notif
                        ? 'small-notif'
                        : ''
                }}">
                    <div class="collapsible-header">
                        <i class="fas fa-shield-alt fa-15x mr-2"></i>
                        @lang('messages.adminka')
                    </div>
                    <div class="collapsible-body p-0">
                        <ul>
                            {{-- approves --}}
                            <li class="position-relative {{ active_if_route_is(['admin/approves']) }}">
                                <a href="/admin/approves" title="@lang('approves.checklist')"
                                    class="{{ $unapproved_notif ? 'small-notif' : '' }}"
                                >
                                    <i class="fas fa-search fa-15x left with-red-hover"></i>
                                    @lang('approves.checklist')
                                </a>
                            </li>

                            {{-- feedback --}}
                            <li class="position-relative {{ active_if_route_is(['admin/feedback']) }}">
                                <a href="/admin/feedback" title="@lang('feedback.contact_us')"
                                    class=" {{ $feedback_notif ? 'small-notif' : '' }}"
                                >
                                    <i class="fas fa-comment-dots fa-15x left with-red-hover"></i>
                                    @lang('feedback.contact_us')
                                </a>
                            </li>

                            @hasRole('master')
                                <li class="divider"></li>

                                {{-- manage-users --}}
                                <li class="position-relative {{ active_if_route_is(['master/manage-users']) }}">
                                    <a href="/master/manage-users" title="@lang('manage-users.manage-users')">
                                        <i class="fas fa-user-cog fa-15x left with-red-hover"></i>
                                        @lang('manage-users.management')
                                    </a>
                                </li>

                                {{-- visitors --}}
                                <li class="position-relative {{ active_if_route_is(['master/visitors']) }}">
                                    <a href="/master/visitors" title="@lang('visitors.visitors')">
                                        <i class="fas fa-users fa-15x left with-red-hover"></i>
                                        @lang('visitors.visitors')
                                    </a>
                                </li>

                                {{-- log-viewer --}}
                                <li class="position-relative {{ active_if_route_is(['log-viewer/logs*']) }}">
                                    <a href="/log-viewer/logs" title="@lang('logs.logs')"
                                        class="{{ $logs_notif ? 'small-notif' : '' }}"
                                    >
                                        <i class="fas fa-file-code fa-15x left with-red-hover"></i>
                                        @lang('logs.logs')
                                    </a>
                                </li>

                                {{-- Trash --}}
                                <li class="position-relative {{ active_if_route_is(['master/trash']) }}">
                                    <a href="/master/trash" title="@lang('messages.trash')"
                                        class="{{ $trash_notif ? 'small-notif' : '' }}"
                                    >
                                        <i class="fas fa-trash fa-15x left with-red-hover"></i>
                                        @lang('messages.trash')
                                    </a>
                                </li>

                                {{-- Horizon --}}
                                <li>
                                    <a href="/horizon/dashboard" title="Horizon">
                                        <i class="fas fa-h-square fa-15x left"></i>
                                        Horizon
                                    </a>
                                </li>

                                {{-- Telescope --}}
                                <li>
                                    <a href="telescope/requests" title="Telescope">
                                        <i class="fas fa-star-and-crescent fa-15x left"></i>
                                        Telescope
                                    </a>
                                </li>
                                <li class="divider"></li>
                            @endhasRole
                        </ul>
                    </div>
                </li>
            </ul>
        @endhasRole

        {{-- statistics --}}
        <li class="{{ active_if_route_is(['statistics']) }}">
            <a href="/statistics" title="@lang('pages.statistics')">
                <i class="fas fa-chart-bar fa-15x left with-red-hover"></i>
                @lang('pages.statistics')
            </a>
        </li>

        {{-- settings --}}
        <li class="{{ active_if_route_is(['settings', 'settings/photo', 'settings/general']) }}">
            <a href="/settings" title="@lang('settings.settings')">
                <i class="fas fa-cog fa-15x left with-red-hover"></i>
                @lang('settings.settings')
            </a>
        </li>

        <li> {{-- logout --}} {{-- This button submits logout-form --}}
            <a href="#" title="@lang('auth.logout')"
                onclick="document.querySelector('#logout-form button').click()"
            >
                <i class="fas fa-sign-out-alt fa-15x left"></i>
                @lang('auth.logout')
            </a>
        </li>

       {{-- logout-form --}}
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hide">
            @csrf
            <button type="submit" class="confirm"
                data-confirm="@lang('messages.sure_to_logout')"
            ></button>
        </form>
    @else
        {{-- Login --}}
        <li class="{{ active_if_route_is(['login']) }}">
            <a href="/login" title="@lang('auth.login')">
                <i class="fas fa-sign-in-alt fa-15x left with-red-hover"></i>
                @lang('auth.login')
            </a>
        </li>
        {{-- Register --}}
        <li class="{{ active_if_route_is(['register']) }}">
            <a href="/register" title="@lang('auth.register')">
                <i class="fas fa-pen-alt fa-15x left with-red-hover"></i>
                @lang('auth.register')
            </a>
        </li>
    @endauth

    {{-- Swith to dark mode --}}
    <li>
        <a href="#" title="@lang('messages.dark_mode')">
            <i class="fas fa-moon fa-15x left"></i>
            <div class="switch">
                <label class="ml-1">
                    @lang('messages.off')

                    <input type="checkbox" id="dark-theme-toggle"
                        {{ getCookie('r_dark_theme') == 1 ? 'checked' : '' }}
                    />
                    <span class="lever"></span>
                    @lang('messages.on')
                </label>
            </div>
        </a>
    </li>
</ul>

<nav class="no-select">
    <div class="nav-wrapper main-navbar" style="z-index:15">
        <div class="px-3 position-relative">
            {{-- Logo --}}
            <a href="/" title="@lang('home.home')" class="brand-logo no-select">
                <img src="{{ asset('storage/other/logo.png') }}" alt="logo" height="30" class="left">
                <span class="left pl-1">@lang('messages.app_name')</span>
            </a>
            {{-- Hamburger menu --}}
            <a href="#" data-target="mobile-sidenav" class="sidenav-trigger no-select">
                <i class="fas fa-bars"></i>
            </a>

            <div class="right">
                @auth
                    {{-- Dropdown Trigger 2 User --}}
                    <a class="right dropdown-trigger position-relative align-to-the-middle"
                        data-target="user-menu-dropdown"
                    >
                        <i class="user-icon-navbar d-block {{ 
                            $trash_notif || $unapproved_notif || $feedback_notif || $logs_notif
                            ? 'small-notif'
                            : '' 
                        }}">
                            <img src="{{ asset('storage/small/users/' . user()->photo) }}"
                                class="z-depth-1 hoverable"
                            />
                        </i>
                    </a>
                @else
                    {{-- Dropdown Trigger 2  --}}
                    <a class="right dropdown-trigger position-relative align-to-the-middle"
                        data-target="user-menu-dropdown"
                        id="_hamb-menu"
                    >
                        <i class="fas fa-bars user-icon-navbar z-depth-1 hoverable waves-effect waves-light d-block center"
                            style="line-height:40px; font-size:19px"
                        ></i>
                    </a>
                @endauth

                {{-- Search button --}}
                <a href="#" data-target="mobile-demo"
                    class="hide-on-small-only right mr-4 align-to-the-middle"
                    title="@lang('pages.search')"
                    id="nav-btn-for-search"
                >
                    <i class="fas fa-search fa-15x"></i>
                </a>

                @auth {{-- Notifications bell --}}
                    <a href="#" id="mark-notifs-as-read"
                        class="right ml-1 mr-4 dropdown-trigger position-relative align-to-the-middle"
                        title="@lang('notifications.notifications')"
                        data-target="notifications-dropdown"
                    >
                        <span style="height:53px"
                            class="{{ ($has_notifications ?? null) ? 'small-notif' : '' }}"
                        >
                            <i class="fas fa-bell fa-15x"></i>
                        </span>
                    </a>
                @endauth
            </div>

            {{-- Regular menu --}}
            <ul class="right hide-on-med-and-down right-borders">
                <li class="{{ active_if_route_is(['/']) }}">
                    <a href="/" title="@lang('home.home')">
                        @lang('home.home')
                    </a>
                </li>

                <li class="{{ active_if_route_is(['recipes']) }}">
                    <a href="/recipes#new" title="@lang('recipes.recipes')">
                        @lang('recipes.recipes')
                    </a>
                </li>

                <li class="{{ active_if_route_is(['help']) }}">
                    <a href="/help" title="@lang('help.help')">
                       @lang('help.help')
                    </a>
                </li>

                <li> {{-- Categories Dropdown Trigger Categories --}}
                    <a class="dropdown-trigger" data-target="categories-dropdown">
                        @lang('pages.categories')
                        <i class="fas fa-caret-down fa-15x right"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

{{-- Search navigation --}}
<nav class="nav-search-form" id="nav-search-form">
    <div class="nav-wrapper container">
        <form action="{{ action('PagesController@search') }}" method="get">
            <div class="input-field">
                <input id="search-input" type="search"
                    name="for"
                    placeholder="@lang('pages.search_details')"
                    required
                >
                <label class="label-icon" for="search-input">
                    <i class="fas fa-search"></i>
                </label>
            </div>
        </form>
    </div>
</nav>

{{-- Categories Dropdown trigger menu --}}
<ul id="categories-dropdown" class="dropdown-content bottom-borders">
    @include('includes.nav.categories')
</ul>

{{-- Notifications --}}
@auth
    <ul id="notifications-dropdown" class="dropdown-content bottom-borders">
        @forelse ($notifications as $notif)
            <li class="{{ !is_null($notif['read_at']) ? 'active' : '' }}">
                <a href="{{ ($notif['data']['link'] ?? '#') }}">
                    <span>
                        <div>
                            <span class="red-text">
                                {{ ($notif['data']['title'] ?? '') }}
                            </span>
                        </div>
                        <span>{!! ($notif['data']['message'] ?? '') !!}</span>
                        <div>
                            <small class="grey-text">
                                {{ time_ago($notif['created_at']) }}
                            </small>
                        </div>
                    </span>
                </a>
            </li>
        @empty
            <div class="center">
                <span class="mx-3">@lang('notifications.no_notifs')</span>
            </div>
        @endforelse
    </ul>
@endauth
