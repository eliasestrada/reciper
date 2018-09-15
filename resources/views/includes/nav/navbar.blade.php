@php
    $all_notif = array_sum([
        $all_unapproved ?? '',
        $all_feedback ?? '',
        $all_notifs ?? '',
        $all_logs ?? ''
    ]);
@endphp

{{-- Categories Dropdown menu --}}
<ul id="dropdown1" class="dropdown-content bottom-borders">
    @include('includes.nav.categories')
</ul>

@auth {{-- User Dropdown menu --}}
    <ul id="dropdown2" class="dropdown-content bottom-borders">
        <li class="{{ active_if_route_is('users/' . user()->id) }}"> {{-- home --}}
            <a href="/users/{{ user()->id }}" title="@lang('includes.user_home')">
                <i class="material-icons left">home</i>@lang('includes.user_home')
            </a>
        </li>

        <li> {{-- add recipe --}}
            <a href="#add-recipe-modal" title="@lang('includes.new_recipe')" class="modal-trigger">
                <i class="material-icons left">add</i>@lang('includes.new_recipe')
            </a>
        </li>

        <li class="{{ active_if_route_is('users/other/my-recipes') }}"> {{-- my recipes --}}
            <a href="/users/other/my-recipes" title="@lang('includes.my_recipes')">
                <i class="material-icons left">insert_drive_file</i>@lang('includes.my_recipes')
            </a>
        </li>

        <li class="{{ active_if_route_is('users') }}"> {{-- users --}}
            <a href="/users" title="@lang('includes.users')">
                <i class="material-icons left">people</i>@lang('includes.users')
            </a>
        </li>

        @hasRole('admin')
            <li class="{{ active_if_route_is('admin/statistics') }}"> {{-- statistics --}}
                <a href="/admin/statistics" title="@lang('includes.statistics')">
                    <i class="material-icons left">insert_chart</i>@lang('includes.statistics')
                </a>
            </li>

            <li class="position-relative {{ active_if_route_is('admin/approves') }}"> {{-- checklist --}}
                <a href="/admin/approves" title="@lang('includes.checklist')" {{ empty($all_unapproved) ? '' : "data-notif=$all_unapproved" }} class="small-notif-btn">
                    <i class="material-icons left">search</i>@lang('includes.checklist')
                </a>
            </li>

            <li class="position-relative {{ active_if_route_is('admin/feedback') }}"> {{-- feedback --}}
                <a href="/admin/feedback" title="@lang('includes.feedback')" {{ empty($all_feedback) ? '' : "data-notif=$all_feedback" }} class="small-notif-btn">
                    <i class="material-icons left">feedback</i>@lang('includes.feedback')
                </a>
            </li>
        @endhasRole

        <li class="position-relative {{ active_if_route_is('notifications') }}"> {{-- notifications --}}
            <a href="/notifications" title="@lang('includes.notifications')" {{ empty($all_notifs) ? '' : "data-notif=$all_notifs" }} class="small-notif-btn">
                <i class="material-icons left">notifications</i>@lang('includes.notifications')
            </a>
        </li>

        <li class="{{ active_if_route_is('settings/general') }}"> {{-- settings/general --}}
            <a href="/settings/general" title="@lang('includes.general')" >
                <i class="material-icons left">build</i>@lang('includes.general')
            </a>
        </li>

        <li class="{{ active_if_route_is('settings/photo') }}"> {{-- settings/photo --}}
            <a href="/settings/photo" title="@lang('includes.photo')">
                <i class="material-icons left">build</i>@lang('includes.photo')
            </a>
        </li>

        @hasRole('master')
            <li class="position-relative {{ active_if_route_is('master/documents') }}"> {{-- Documents --}}
                <a href="/master/documents" title="@lang('documents.docs')">
                    <i class="material-icons left">work</i>@lang('documents.docs')
                </a>
            </li>
            <li class="position-relative {{ active_if_route_is('log-viewer/logs*') }}"> {{-- log-viewer --}}
                <a href="/log-viewer/logs" title="@lang('logs.logs')" {{ empty($all_logs) ? '' : "data-notif=$all_logs" }} class="small-notif-btn">
                    <i class="material-icons left">library_books</i>@lang('logs.logs')
                </a>
            </li>
        @endhasRole

        <li> {{-- logout --}} {{-- This button submits logout-form --}}
            <a href="#" title="@lang('includes.logout')" onclick="$('logout-form').submit()" id="_logout_btn">
                <i class="material-icons left">power_settings_new</i>@lang('includes.logout')
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
                @lang('website.name')
            </a>
            {{-- Hamburger menu --}}
            <a href="#" data-target="mobile-demo" class="sidenav-trigger noselect">
                <i class="material-icons">menu</i>
            </a>

            <div class="right">
                @auth
                    {{-- Dropdown Trigger 2 User --}}
                    <a id="_user-menu-trigger" class="right dropdown-trigger small-notif-btn position-relative" href="#!" data-target="dropdown2" title="@lang('includes.user_home')" {{ $all_notif ? 'data-notif='.$all_notif : '' }}>
                        <i class="user-icon-navbar">
                            <img class="small-notif-btn" src="{{ asset('storage/users/' . user()->image) }}">
                        </i>
                    </a>
                @endauth
                        
                {{-- Search button --}}
                <a href="#" data-target="mobile-demo" class="right px-1" title="@lang('includes.search')" id="nav-btn-for-search">
                    <i class="material-icons">search</i>
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

                <li> {{-- Dropdown Trigger 1 Categories --}}
                    <a class="dropdown-trigger" href="#!" data-target="dropdown1">
                        @lang('includes.categories')
                        <i class="material-icons right">arrow_drop_down</i>
                    </a>
                </li>


                @guest
                    <li>
                        <a href="/login" data-target="dropdown3" title="@lang('includes.enter')">
                            @lang('includes.enter')
                            <i class="material-icons right">exit_to_app</i>
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
                    <i class="material-icons">search</i>
                </label>
                <i class="material-icons">close</i>
            </div>
        </form>
    </div>
</nav>