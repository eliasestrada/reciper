@extends('layouts.auth')

@section('title', trans('manage-users.manage-users'))


@section('content')

<div class="page">
    <div class="center mb-3">
        <h1 class="header mb-4">
            <i class="fas fa-user-cog red-text"></i> 
            @lang('manage-users.management'): <span class="red-text">{{ number_format($users->count()) }}</span>
        </h1>
        <div class="divider"></div>
    </div>
    <div class="row container">
        <ul class="col s12 m6">
            <li><i class="fas fa-fire tiny main-text"></i> - @lang('users.streak_days')</li>
            <li><i class="fas fa-book-open tiny main-text"></i> - @lang('recipes.recipes')</li>
            <li><i class="fas fa-award main-text tiny"></i> - @lang('users.popularity')</li>
            <li><i class="main-text fas fa-lightbulb tiny"></i> - @lang('users.xp')</li>
        </ul>
        <ul class="col s12 m6">
            <li><i class="green-text fas fa-circle tiny"></i> - @lang('manage-users.active_users')</li>
            <li><i class="red-text fas fa-circle tiny"></i> - @lang('manage-users.not_active_users')</li>
            <li><i class="main-text fas fa-circle tiny"></i> - @lang('manage-users.banned_users')</li>
        </ul>
    </div>

    <table class="responsive-table striped highlight">
        <div class="divider"></div>
        <thead>
            <tr>
                <th class="main-text py-1">
                    <a href="/master/manage-users" class="{{ $active == 'id' ? 'red-text' : '' }}">#</a>
                </th>
                <th class="py-1">@lang('forms.name')</th>
                <th class="py-1">
                    <a href="/master/manage-users?order=streak_days" title="@lang('users.streak_days')">
                        <i class="fas fa-fire {{ $active == 'streak_days' ? 'red-text' : '' }}"></i>
                    </a>
                </th>
                <th class="py-1">
                    <a href="/master/manage-users?order=recipes" title="@lang('recipes.recipes')">
                        <i class="fas fa-book-open {{ $active == 'recipes' ? 'red-text' : '' }}"></i>
                    </a>
                </th>
                <th class="py-1">
                    <a href="/master/manage-users?order=popularity" title="@lang('users.popularity')">
                        <i class="fas fa-award {{ $active == 'popularity' ? 'red-text' : '' }}"></i>
                    </a>
                </th>
                <th class="py-1">
                    <a href="/master/manage-users?order=xp" title="@lang('users.xp')">
                        <i class="fas fa-lightbulb {{ $active == 'xp' ? 'red-text' : '' }}"></i>
                    </a>
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td class="py-1">{{ $user->id }}</td>
                    <td class="py-1">
                        <a href="/master/manage-users/{{ $user->username }}">
                            <span class="z-depth-1 new badge {{ $user->getStatusColor() }}">
                                {{ $user->getName() }}
                            </span>
                        </a>
                    </td>
                    <td class="py-1">{{ $user->streak_days }}</td>
                    <td class="py-1">{{ $user->recipes->count() }}</td>
                    <td class="py-1">{{ $user->popularity }}</td>
                    <td class="py-1">{{ $user->xp }}</td>
                </tr>
            @endforeach
            {{ $users->links() }}
        </tbody>
    </table>
</div>

@endsection