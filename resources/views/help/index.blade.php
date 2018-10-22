@extends(auth()->check() ? 'layouts.auth' : 'layouts.guest')

@section('title', trans('messages.help'))

@section('content')

<div class="page">
    <div class="center"><h1 class="header">@lang('messages.help')</h1></div>

    <div class="row mt-4">
        @foreach ($help_categories as $category)
            <div class="col s12 m6 l4">
                <h5 class="grey-dark-text header">
                    <i class="fas {{ $category['icon'] }} left red-text w20"></i>
                    {{ $category['title'] }}
                </h5>
                <div class="divider"></div>

                <ul>
                    @foreach ($help as $question)
                        @if ($question['help_category_id'] == $category['id'])
                            <li>
                                <a href="/help/{{ $question['id'] }}" class="main-dark-text text-hover" style="font-size:1.05em">
                                    <span class="red-text">#</span> {{ $question['title'] }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
        @endforeach
    </div>
</div>

@endsection