@extends('layouts.app')

@section('title', trans('manage-users.manage-users'))


@section('content')

<div class="page">
    <div class="center mb-3">
        <h1 class="headline mb-4">
            <i class="fas fa-users red-text"></i> 
            @lang('manage-users.management'): <span class="red-text">{{ number_format($users->count()) }}</span>
        </h1>
        <div class="divider"></div>
    </div>
    <div class="row container">
        <ul class="col s12 m6">
            <li><i class="fas fa-fire tiny" style="color:orangered"></i> - @lang('users.streak_days')</li>
            <li><i class="fas fa-star tiny" style="color:#d49d10"></i> - @lang('messages.favorites')</li>
            <li><i class="main-text fas fa-award tiny"></i> - @lang('users.popularity')</li>
            <li><i class="green-text fas fa-lightbulb tiny"></i> - @lang('users.xp')</li>
        </ul>
        <ul class="col s12 m6">
            <li><i class="green-text fas fa-circle tiny"></i> - </li>
            <li><i class="main-text fas fa-circle tiny"></i> - </li>
            <li><i class="red-text fas fa-circle tiny"></i> - </li>
        </ul>
    </div>

    <table class="responsive-table striped highlight">
        <div class="divider"></div>
        <thead>
            <tr>
                <th class="main-text py-1">#</th>
                <th class="main-text py-1">@lang('forms.name')</th>
                <th class="main-text py-1">@lang('forms.email')</i></th>
                <th class="py-1"><i class="fas fa-fire" style="color:orangered" title="@lang('users.streak_days')"></i></th>
                <th class="py-1"><i class="fas fa-star" style="color:#d49d10" title="@lang('messages.favorites')"></i></th>
                <th class="py-1"><i class="fas fa-award main-text" title="@lang('users.popularity')"></i></th>
                <th class="py-1"><i class="fas fa-lightbulb green-text" title="@lang('users.xp')"></i></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td class="py-1">{{ $user->id }}</td>
                    <td class="py-1">
                        <a href="/master/manage-users/{{ $user->id }}">
                            <span class="z-depth-1 new badge">{{ $user->name }}</span>
                        </a>
                    </td>
                    <td class="py-1">{{ $user->email }}</td>
                    <td class="py-1">{{ $user->streak_days }}</td>
                    <td class="py-1">{{ $user->favs_count }}</td>
                    <td class="py-1">{{ $user->popularity }}</td>
                    <td class="py-1">{{ $user->xp }}</td>
                </tr>
            @endforeach
            {{ $users->links() }}
        </tbody>
    </table>
</div>

@endsection