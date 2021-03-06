@extends(setLayout())

@section('title', trans('users.all_authors'))

@section('content')

<div class="page">
    <div class="center pb-3">
        <h1 class="header">
            <i class="fas fa-user-friends red-text"></i> @lang('users.all_authors')
        </h1>
    </div>

    <div class="row">
        @foreach ($users as $user)
            <div class="col s12 m6 l4">
                <ul class="collection my-1 z-depth-1 hoverable">
                    <li class="collection-item avatar">
                        <a href="/users/{{ $user->username }}">
                            <img src="{{ asset('storage/small/users/'.$user->photo) }}"
                                alt="{{ $user->getName() }}"
                                class="circle"
                            >
                        </a>
                        <span class="title">
                            {!! get_online_icon(time_ago($user->online_check)) !!} {{ $user->getName() }}
                        </span>
                        <p>@lang('date.online') {{ time_ago($user->online_check, 'online') }}</p>
                        <p>@lang('users.xp'): {{ $user->xp }}</p>
                    </li>
                </ul>
            </div>
        @endforeach
    </div>
    {{ $users->links() }}
</div>


@endsection
