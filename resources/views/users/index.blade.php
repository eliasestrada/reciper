@extends('layouts.app')

@section('title', trans('users.all_authors'))

@section('content')

<div class="page">
    <div class="center">
        <h1 class="headline">@lang('users.all_authors')</h1>
    </div>

    <div class="item-list">
        <ul class="row unstyled-list">
            @foreach ($users as $user)
                <a href="/users/{{ $user->id }}" title="{{ $user->name }}" class="grey-text">
                    <li class="col s12 m6 l4">
                        <img src="{{ asset('storage/users/'.$user->image) }}" alt="{{ $user->name }}" style="width:67px; height:71px;" />

                        <div class="item-content">
                            <h6 class="project-name">{{ $user->name }}</h6>
                            <p class="project-title">
                                {!! get_online_icon(time_ago($user->online_at)) !!}
                                @lang('date.online') 
                                {{ time_ago($user->online_at, 'online') }}
                            </p>
                        </div>
                    </li>
                </a>
            @endforeach
        </ul>
    </div>
    {{ $users->links() }}
</div>


@endsection
