{{-- Categories Dropdown menu --}}
<ul id="dropdown1" class="dropdown-content bottom-borders">
    @include('includes.nav.categories')
</ul>

@auth {{-- User Dropdown menu --}}
    <ul id="dropdown2" class="dropdown-content bottom-borders">
        <li class="{{ active_if_route_is('users/' . user()->id) }}"> {{-- home --}}
            <a href="/users/{{ user()->id }}" title="@lang('includes.my_account')">
                <i class="fas fa-user-circle fa-15x left"></i>@lang('includes.my_account')
            </a>
        </li>

        <li> {{-- add recipe --}}
            <a href="#add-recipe-modal" title="@lang('includes.new_recipe')" class="modal-trigger">
                <i class="fas fa-plus-circle fa-15x left"></i>@lang('includes.new_recipe')
            </a>
        </li>

        <li class="{{ active_if_route_is('users/other/my-recipes') }}"> {{-- my recipes --}}
            <a href="/users/other/my-recipes" title="@lang('includes.my_recipes')">
                <i class="fas fa-book-open fa-15x left"></i>@lang('includes.my_recipes')
            </a>
        </li>

        <li class="{{ active_if_route_is('users') }}"> {{-- users --}}
            <a href="/users" title="@lang('includes.users')">
                <i class="fas fa-user-friends fa-15x left"></i>@lang('includes.users')
            </a>
        </li>

        <li class="{{ active_if_route_is('statistics') }}"> {{-- statistics --}}
            <a href="/statistics" title="@lang('includes.statistics')">
                <i class="fas fa-chart-pie fa-15x left"></i>@lang('includes.statistics')
            </a>
        </li>

        @hasRole('admin')
            <li class="position-relative {{ active_if_route_is('admin/approves') }}"> {{-- checklist --}}
                <a href="/admin/approves" title="@lang('includes.checklist')" class="{{ $unapproved_notif ? 'small-notif' : '' }}">
                    <i class="fas fa-search fa-15x left"></i>@lang('includes.checklist')
                </a>
            </li>

            <li class="position-relative {{ active_if_route_is('admin/feedback') }}"> {{-- feedback --}}
                <a href="/admin/feedback" title="@lang('feedback.contact_us')" class=" {{ $feedback_notif ? 'small-notif' : '' }}">
                    <i class="fas fa-comment-dots fa-15x left"></i>@lang('feedback.contact_us')
                </a>
            </li>
        @endhasRole

        <li class="position-relative {{ active_if_route_is('notifications') }}"> {{-- notifications --}}
            <a href="/notifications" title="@lang('includes.notifications')" class="{{ $notifs_notif ? 'small-notif' : '' }} ">
                <i class="fas fa-bell fa-15x left"></i>@lang('includes.notifications')
            </a>
        </li>

        <li class="{{ active_if_route_is('settings') }}"> {{-- settings --}}
            <a href="/settings" title="@lang('settings.settings')">
                <i class="fas fa-cog fa-15x left"></i>@lang('settings.settings')
            </a>
        </li>
        @hasRole('master')
            <li class="position-relative {{ active_if_route_is('master/visitors') }}"> {{-- visitors --}}
                <a href="/master/visitors" title="@lang('visitors.visitors')">
                    <i class="fas fa-users fa-15x left"></i>@lang('visitors.visitors')
                </a>
            </li>
            <li class="position-relative {{ active_if_route_is('master/documents') }}"> {{-- Documents --}}
                <a href="/master/documents" title="@lang('documents.documents')">
                    <i class="fas fa-copy fa-15x left"></i>@lang('documents.documents')
                </a>
            </li>
            <li class="position-relative {{ active_if_route_is('log-viewer/logs*') }}"> {{-- log-viewer --}}
                <a href="/log-viewer/logs" title="@lang('logs.logs')" class=" {{ $logs_notif ? 'small-notif' : '' }}">
                    <i class="fas fa-file-code fa-15x left"></i>@lang('logs.logs')
                </a>
            </li>
        @endhasRole

        <li> {{-- logout --}} {{-- This button submits logout-form --}}
            <a href="#" title="@lang('includes.logout')" onclick="$('logout-form').submit()" id="_logout_btn">
                <i class="fas fa-sign-out-alt fa-15x left"></i>@lang('includes.logout')
            </a>
        </li>

        {{-- logout-form --}}
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf <button type="submit"></button>
        </form>
    </ul>
@endauth

<nav>
    <div class="nav-wrapper main" style="z-index:15">
        <div class="px-3">
            {{-- Logo --}}
            <a href="/" title="@lang('includes.home')" class="brand-logo noselect">
                <img src="{{ asset('storage/other/logo.svg') }}" alt="logo" height="46" class="mt-1 left">
                <span class="left pl-2">@lang('website.name')</span>
            </a>
            {{-- Hamburger menu --}}
            <a href="#" data-target="mobile-demo" class="sidenav-trigger noselect">
                <i class="fas fa-bars"></i>
            </a>

            <div class="right">
                @auth
                    {{-- Dropdown Trigger 2 User --}}
                    <a id="_user-menu-trigger" class="mt-2 right dropdown-trigger position-relative" href="#!" data-target="dropdown2">
                        <i class="user-icon-navbar {{ $unapproved_notif || $feedback_notif || $notifs_notif || $logs_notif ? 'small-notif' : '' }}">
                            <img src="{{ asset('storage/users/' . user()->image) }}">
                        </i>
                    </a>
                @endauth

                {{-- Search button --}}
                <a href="#" data-target="mobile-demo" class="right pr-4 pl-3" title="@lang('includes.search')" id="nav-btn-for-search">
                    <i class="fas fa-search fa-15x d-inline"></i>
                </a>
            </div>

            {{-- Regular menu --}}
            <ul class="right hide-on-med-and-down right-borders">
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
                <li class="{{ active_if_route_is('help') }}">
                    <a href="/help" title="@lang('help.help')">
                        @lang('help.help')
                    </a>
                </li>

                <li> {{-- Dropdown Trigger 1 Categories --}}
                    <a class="dropdown-trigger" href="#!" data-target="dropdown1">
                        @lang('includes.categories')
                        <i class="fas fa-caret-down fa-15x right"></i>
                    </a>
                </li>

                @guest
                    <li>
                        <a href="/login" title="@lang('includes.enter')">
                            @lang('includes.enter')
                            <i class="fas fa-sign-in-alt fa-15x right"></i>
                        </a>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

{{-- Search navigation --}}
<nav class="main-hover nav-search-form" id="nav-search-form">
    <div class="nav-wrapper container">
        <form action="{{ action('PagesController@search') }}" method="get">
            <div class="input-field">
                <input id="search-input" type="search" name="for" placeholder="@lang('pages.search_details')" required>
                <label class="label-icon" for="search-input">
                    <i class="fas fa-search grey-text"></i>
                </label>
            </div>
        </form>
    </div>
</nav>